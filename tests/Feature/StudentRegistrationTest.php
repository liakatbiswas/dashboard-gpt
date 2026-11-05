<?php

namespace Tests\Feature;

use App\Actions\Fortify\CreateNewUser;
use App\Models\AccessSetting;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\RoleSeeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\Concerns\CreatesSuperAdmin;
use Tests\TestCase;

class StudentRegistrationTest extends TestCase
{
    use CreatesSuperAdmin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->seed(DatabaseSeeder::class);
    }

    private function payload(): array
    {
        return ['name' => 'Student One', 'email' => 'student-one@example.invalid',
            'password' => 'student-password-123', 'password_confirmation' => 'student-password-123'];
    }

    public function test_public_registration_always_assigns_only_student_role(): void
    {
        $this->post('/register', $this->payload() + [
            'role' => 'super-admin', 'roles' => ['super-admin'], 'permissions' => ['role.create'],
            'super_admin_user_id' => 1, 'guard_name' => 'api',
        ])->assertRedirect('/student/dashboard');

        $user = User::query()->where('email', 'student-one@example.invalid')->firstOrFail();
        $this->assertSame(['student'], $user->getRoleNames()->all());
        $this->assertFalse($user->isSuperAdmin());
        $this->assertNull(AccessSetting::query()->findOrFail(1)->super_admin_user_id);
        $this->assertAuthenticatedAs($user);
        $this->get('/student/dashboard')->assertOk()->assertSee('Your student account');
        $this->get('/dashboard')->assertForbidden();
    }

    public function test_owner_can_close_and_reopen_registration(): void
    {
        $owner = $this->createSuperAdmin();
        $this->actingAs($owner)->put('/registration-settings', ['student_registration_enabled' => '0'])
            ->assertRedirect('/registration-settings')->assertSessionHas('success');
        $this->assertFalse(AccessSetting::query()->findOrFail(1)->student_registration_enabled);

        $this->put('/registration-settings', ['student_registration_enabled' => '1'])
            ->assertRedirect('/registration-settings');
        $setting = AccessSetting::query()->findOrFail(1);
        $this->assertTrue($setting->student_registration_enabled);
        $this->assertSame($owner->id, $setting->updated_by);
    }

    public function test_closed_registration_blocks_get_and_post_and_hides_links(): void
    {
        AccessSetting::query()->whereKey(1)->update(['student_registration_enabled' => false]);

        $this->get('/register')->assertForbidden()->assertSee('Registration is closed');
        $this->postJson('/register', $this->payload())->assertForbidden();
        $this->get('/login')->assertOk()->assertDontSee('href="'.route('register').'"', false);
        $this->get('/')->assertOk()->assertDontSee('href="'.route('register').'"', false);
        $this->assertDatabaseMissing('users', ['email' => 'student-one@example.invalid']);
    }

    public function test_creation_action_rechecks_setting_inside_transaction(): void
    {
        AccessSetting::query()->whereKey(1)->update(['student_registration_enabled' => false]);

        try {
            app(CreateNewUser::class)->create($this->payload());
            $this->fail('Registration must be blocked even when the middleware is bypassed.');
        } catch (HttpException $exception) {
            $this->assertSame(403, $exception->getStatusCode());
        }

        $this->assertDatabaseMissing('users', ['email' => 'student-one@example.invalid']);
    }

    public function test_existing_student_can_sign_in_when_registration_is_closed(): void
    {
        $student = User::factory()->create();
        $student->assignRole('student');
        AccessSetting::query()->whereKey(1)->update(['student_registration_enabled' => false]);

        $this->post('/login', ['email' => $student->email, 'password' => 'password'])
            ->assertRedirect('/student/dashboard');
        $this->get('/student/dashboard')->assertOk();
        $this->assertAuthenticatedAs($student);
    }

    public function test_student_cannot_change_setting_even_with_management_permissions(): void
    {
        $student = User::factory()->create();
        $student->assignRole('student');
        $student->givePermissionTo(['registration.manage', 'role.create', 'permission.create', 'dashboard.view']);

        $this->actingAs($student)->get('/registration-settings')->assertForbidden();
        $this->put('/registration-settings', ['student_registration_enabled' => false])->assertForbidden();
        $this->get('/roles')->assertForbidden();
        $this->post('/permissions', ['name' => 'malicious.action'])->assertForbidden();
        $this->assertTrue(AccessSetting::query()->findOrFail(1)->student_registration_enabled);
    }

    public function test_reseeding_backfills_roleless_users_without_resetting_custom_role_permissions(): void
    {
        $oldUser = User::factory()->create();
        $extra = Permission::create(['name' => 'lessons.view', 'guard_name' => 'web']);
        $studentRole = Role::findByName('student', 'web');
        $studentRole->givePermissionTo($extra);

        $this->seed(RoleSeeder::class);

        $this->assertTrue($oldUser->fresh()->hasRole('student'));
        $this->assertTrue($studentRole->fresh()->hasPermissionTo('lessons.view'));
        $this->assertTrue($studentRole->fresh()->hasPermissionTo('student.dashboard.view'));
    }

    public function test_setting_update_cannot_replace_the_single_owner(): void
    {
        $owner = $this->createSuperAdmin();
        $student = User::factory()->create();
        $student->assignRole('student');

        $this->actingAs($owner)->put('/registration-settings', [
            'student_registration_enabled' => true,
            'super_admin_user_id' => $student->id,
        ])->assertRedirect('/registration-settings');

        $this->assertSame($owner->id, AccessSetting::query()->findOrFail(1)->super_admin_user_id);
        $this->assertFalse($student->isSuperAdmin());
    }

    public function test_student_dashboard_escapes_the_student_name(): void
    {
        $name = '<script>alert(1)</script>';
        $student = User::factory()->create(['name' => $name]);
        $student->assignRole('student');

        $this->actingAs($student)->get('/student/dashboard')
            ->assertOk()->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
            ->assertDontSee($name, false);
    }

    public function test_open_registration_form_and_login_link_render(): void
    {
        $this->get('/register')->assertOk()->assertSee('Create a student account');
        $this->get('/login')->assertOk()->assertSee('href="'.route('register').'"', false);
    }
}
