<?php

namespace Tests\Feature;

use App\Models\User;
use App\Policies\RolePolicy;
use Database\Seeders\DatabaseSeeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\Concerns\CreatesSuperAdmin;
use Tests\TestCase;

class RoleManagementTest extends TestCase
{
    use CreatesSuperAdmin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_owner_can_read_create_and_edit_role_forms(): void
    {
        $this->actingAs($this->createSuperAdmin())->get('/roles')->assertOk()->assertSee('Create Role');
        $this->get('/roles/create')->assertOk()->assertSee('Role permissions');
        $this->get('/roles/'.Role::findByName('student')->id.'/edit')->assertOk();
    }

    public function test_owner_can_create_update_and_delete_a_custom_role(): void
    {
        $owner = $this->createSuperAdmin();
        $permission = Permission::findByName('student.dashboard.view', 'web');

        $this->actingAs($owner)->post('/roles', [
            'name' => 'exam-manager', 'description' => 'Exam coordination', 'permissions' => [$permission->id],
            'guard_name' => 'api',
        ])->assertRedirect('/roles');
        $role = Role::findByName('exam-manager', 'web');
        $this->assertTrue($role->hasPermissionTo($permission));
        $this->assertSame('Exam coordination', $role->description);
        $this->assertDatabaseMissing('roles', ['name' => 'exam-manager', 'guard_name' => 'api']);

        $this->put('/roles/'.$role->id, ['name' => 'exam-officer', 'description' => 'Updated', 'permissions' => []])
            ->assertRedirect('/roles');
        $this->assertSame('Updated', $role->fresh()->description);
        $this->assertSame(0, $role->fresh()->permissions()->count());

        $this->delete('/roles/'.$role->id)->assertRedirect('/roles');
        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }

    public function test_student_and_owner_roles_cannot_be_renamed_or_deleted(): void
    {
        $this->actingAs($this->createSuperAdmin());
        foreach (['student', 'super-admin'] as $name) {
            $role = Role::findByName($name, 'web');
            $this->putJson('/roles/'.$role->id, ['name' => 'renamed-'.$name])
                ->assertUnprocessable()->assertJsonValidationErrors('name');
            $this->deleteJson('/roles/'.$role->id)
                ->assertUnprocessable()->assertJsonValidationErrors('role');
            $this->assertDatabaseHas('roles', ['id' => $role->id, 'name' => $name]);
        }
    }

    public function test_student_core_permission_is_retained_when_role_is_edited(): void
    {
        $role = Role::findByName('student', 'web');

        $this->actingAs($this->createSuperAdmin())->put('/roles/'.$role->id, [
            'name' => 'student', 'description' => 'Default student account', 'permissions' => [],
        ])->assertRedirect('/roles');

        $this->assertTrue($role->fresh()->hasPermissionTo('student.dashboard.view'));
        $this->assertSame('Default student account', $role->fresh()->description);
    }

    public function test_role_with_assigned_users_cannot_be_deleted(): void
    {
        $role = Role::create(['name' => 'class-rep', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $user->assignRole($role);

        $this->actingAs($this->createSuperAdmin())->deleteJson('/roles/'.$role->id)
            ->assertUnprocessable()->assertJsonValidationErrors('role');
        $this->assertTrue($user->fresh()->hasRole($role));
    }

    public function test_duplicate_invalid_and_foreign_guard_permissions_are_rejected(): void
    {
        $other = Permission::create(['name' => 'api.read', 'guard_name' => 'api']);
        $this->actingAs($this->createSuperAdmin())->postJson('/roles', ['name' => 'student'])
            ->assertUnprocessable()->assertJsonValidationErrors('name');
        $this->postJson('/roles', ['name' => 'Invalid role'])
            ->assertUnprocessable()->assertJsonValidationErrors('name');
        $this->postJson('/roles', ['name' => 'api-reader', 'permissions' => [$other->id]])
            ->assertUnprocessable()->assertJsonValidationErrors('permissions.0');
    }

    public function test_student_is_denied_all_role_crud_routes_even_with_role_permissions(): void
    {
        $student = User::factory()->create();
        $student->assignRole('student');
        $student->givePermissionTo(['role.view', 'role.create', 'role.update', 'role.delete']);
        $role = Role::findByName('student');

        $this->actingAs($student)->get('/roles')->assertForbidden();
        $this->get('/roles/create')->assertForbidden();
        $this->post('/roles', ['name' => 'forbidden'])->assertForbidden();
        $this->get('/roles/'.$role->id.'/edit')->assertForbidden();
        $this->put('/roles/'.$role->id, ['name' => 'forbidden'])->assertForbidden();
        $this->delete('/roles/'.$role->id)->assertForbidden();
    }

    public function test_role_policy_allows_only_the_single_owner(): void
    {
        $owner = $this->createSuperAdmin();
        $student = User::factory()->create();
        $student->assignRole('student');
        $role = Role::findByName('student');
        $policy = new RolePolicy;

        $this->assertTrue($policy->viewAny($owner));
        $this->assertTrue($policy->create($owner));
        $this->assertTrue($policy->update($owner, $role));
        $this->assertFalse($policy->viewAny($student));
        $this->assertFalse($policy->create($student));
        $this->assertFalse($policy->update($student, $role));
        $this->assertFalse($policy->delete($student, $role));
    }
}
