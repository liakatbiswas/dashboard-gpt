<?php

namespace Tests\Feature;

use App\Models\User;
use App\Policies\PermissionPolicy;
use Database\Seeders\DatabaseSeeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\Concerns\CreatesSuperAdmin;
use Tests\TestCase;

class PermissionManagementTest extends TestCase
{
    use CreatesSuperAdmin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_owner_can_read_create_and_edit_permission_forms(): void
    {
        $this->actingAs($this->createSuperAdmin())->get('/permissions')->assertOk()->assertSee('Create Permission');
        $this->get('/permissions/create')->assertOk();
        $this->get('/permissions/'.Permission::findByName('dashboard.view')->id.'/edit')->assertOk();
    }

    public function test_owner_can_create_update_and_delete_custom_permissions(): void
    {
        $this->actingAs($this->createSuperAdmin())->post('/permissions', [
            'name' => 'reports.export', 'description' => 'Download reports', 'guard_name' => 'api',
        ])->assertRedirect('/permissions');
        $permission = Permission::findByName('reports.export', 'web');
        $this->assertSame('Download reports', $permission->description);

        $this->put('/permissions/'.$permission->id, ['name' => 'reports.download', 'description' => 'Updated'])
            ->assertRedirect('/permissions');
        $this->assertDatabaseHas('permissions', ['id' => $permission->id, 'name' => 'reports.download', 'guard_name' => 'web']);

        $this->delete('/permissions/'.$permission->id)->assertRedirect('/permissions');
        $this->assertDatabaseMissing('permissions', ['id' => $permission->id]);
    }

    public function test_system_permission_can_be_described_but_not_renamed_or_deleted(): void
    {
        $permission = Permission::findByName('dashboard.view', 'web');
        $this->actingAs($this->createSuperAdmin())->put('/permissions/'.$permission->id, [
            'name' => 'dashboard.view', 'description' => 'Open the owner dashboard',
        ])->assertRedirect('/permissions');
        $this->assertSame('Open the owner dashboard', $permission->fresh()->description);

        $this->putJson('/permissions/'.$permission->id, ['name' => 'renamed.permission'])
            ->assertUnprocessable()->assertJsonValidationErrors('name');
        $this->deleteJson('/permissions/'.$permission->id)
            ->assertUnprocessable()->assertJsonValidationErrors('permission');
        $this->assertDatabaseHas('permissions', ['id' => $permission->id, 'name' => 'dashboard.view']);
    }

    public function test_deleting_custom_permission_clears_role_assignments_and_permission_cache(): void
    {
        $permission = Permission::create(['name' => 'reports.export', 'guard_name' => 'web']);
        $role = Role::create(['name' => 'report-reader', 'guard_name' => 'web']);
        $role->givePermissionTo($permission);
        $user = User::factory()->create();
        $user->assignRole($role);
        $this->assertTrue($user->can('reports.export'));

        $this->actingAs($this->createSuperAdmin())->delete('/permissions/'.$permission->id)
            ->assertRedirect('/permissions');

        $this->assertFalse($user->fresh()->can('reports.export'));
        $this->assertDatabaseMissing('role_has_permissions', ['permission_id' => $permission->id]);
    }

    public function test_duplicate_or_invalid_permission_names_are_rejected(): void
    {
        $this->actingAs($this->createSuperAdmin())->postJson('/permissions', ['name' => 'dashboard.view'])
            ->assertUnprocessable()->assertJsonValidationErrors('name');
        $this->postJson('/permissions', ['name' => '<script>alert(1)</script>'])
            ->assertUnprocessable()->assertJsonValidationErrors('name');
        $this->postJson('/permissions', ['name' => 'new.action', 'description' => str_repeat('x', 501)])
            ->assertUnprocessable()->assertJsonValidationErrors('description');
    }

    public function test_student_is_denied_permission_crud_even_with_management_permissions(): void
    {
        $student = User::factory()->create();
        $student->assignRole('student');
        $student->givePermissionTo(['permission.view', 'permission.create', 'permission.update', 'permission.delete']);
        $permission = Permission::findByName('dashboard.view');

        $this->actingAs($student)->get('/permissions')->assertForbidden();
        $this->get('/permissions/create')->assertForbidden();
        $this->post('/permissions', ['name' => 'forbidden.action'])->assertForbidden();
        $this->get('/permissions/'.$permission->id.'/edit')->assertForbidden();
        $this->put('/permissions/'.$permission->id, ['name' => 'forbidden.action'])->assertForbidden();
        $this->delete('/permissions/'.$permission->id)->assertForbidden();
    }

    public function test_permission_descriptions_are_escaped_in_the_catalog(): void
    {
        $description = '<script>alert(1)</script>';
        Permission::create(['name' => 'reports.preview', 'guard_name' => 'web', 'description' => $description]);

        $this->actingAs($this->createSuperAdmin())->get('/permissions')
            ->assertOk()->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
            ->assertDontSee($description, false);
    }

    public function test_permission_policy_allows_only_the_single_owner(): void
    {
        $owner = $this->createSuperAdmin();
        $student = User::factory()->create();
        $permission = Permission::findByName('dashboard.view');
        $policy = new PermissionPolicy;

        $this->assertTrue($policy->viewAny($owner));
        $this->assertTrue($policy->create($owner));
        $this->assertTrue($policy->update($owner, $permission));
        $this->assertFalse($policy->viewAny($student));
        $this->assertFalse($policy->create($student));
        $this->assertFalse($policy->update($student, $permission));
        $this->assertFalse($policy->delete($student, $permission));
    }
}
