<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Tests\TestCase;

class AuthenticationRedirectTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_registration_opens_the_pending_page_without_granting_admin_access(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->post('/register', [
            'name' => 'New Account',
            'email' => 'new-account@example.invalid',
            'password' => 'new-account-password-123',
            'password_confirmation' => 'new-account-password-123',
            'role' => 'super-admin',
            'permissions' => ['dashboard.view'],
        ])->assertRedirect('/account/pending');

        $user = User::query()->where('email', 'new-account@example.invalid')->firstOrFail();
        $this->assertAuthenticatedAs($user);
        $this->assertSame(0, $user->roles()->count());
        $this->assertFalse($user->can('dashboard.view'));

        $this->withCookie(config('session.cookie'), session()->getId())
            ->get('/account/pending')
            ->assertOk()
            ->assertSee('অনুমতির অপেক্ষায়')
            ->assertSee($user->email)
            ->assertSee('name="_token"', false);
    }

    public function test_registration_discards_an_inaccessible_intended_destination(): void
    {
        $this->withSession(['url.intended' => url('/settings')])
            ->post('/register', [
                'name' => 'Pending Account',
                'email' => 'pending-account@example.invalid',
                'password' => 'pending-account-password-123',
                'password_confirmation' => 'pending-account-password-123',
            ])
            ->assertRedirect('/account/pending')
            ->assertSessionMissing('url.intended');
    }

    public function test_existing_unprivileged_user_logs_in_to_the_pending_page(): void
    {
        $user = User::factory()->create();

        $this->withSession(['url.intended' => url('/dashboard')])
            ->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect('/account/pending')
            ->assertSessionMissing('url.intended');

        $this->assertAuthenticatedAs($user);
    }

    public function test_administrator_still_logs_in_to_the_dashboard(): void
    {
        $this->seed(DatabaseSeeder::class);
        $user = User::factory()->create();
        $user->assignRole('admin');

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);
        $this->get('/dashboard')->assertOk();
    }

    public function test_authorized_user_keeps_an_intended_destination(): void
    {
        $this->seed(DatabaseSeeder::class);
        $user = User::factory()->create();
        $user->givePermissionTo('dashboard.view');

        $this->withSession(['url.intended' => url('/user/confirm-password')])
            ->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect('/user/confirm-password');
    }

    public function test_pending_page_requires_authentication(): void
    {
        $this->get('/account/pending')->assertRedirect('/login');
    }

    public function test_pending_page_opens_dashboard_after_permission_is_granted(): void
    {
        $this->seed(DatabaseSeeder::class);
        $user = User::factory()->create();
        $this->actingAs($user)->get('/account/pending')->assertOk();

        $user->givePermissionTo('dashboard.view');

        $this->actingAs($user->fresh())->get('/account/pending')->assertRedirect('/dashboard');
    }

    public function test_pending_users_cannot_access_protected_dashboard_or_settings(): void
    {
        $this->seed(DatabaseSeeder::class);
        $user = User::factory()->create();

        $this->actingAs($user)->get('/dashboard')->assertForbidden();
        $this->get('/settings')->assertForbidden();
        $this->getJson('/dashboard')->assertForbidden();
    }

    public function test_signed_in_pending_user_is_redirected_safely_from_guest_pages(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/register')
            ->assertRedirect('/account/pending');

        $this->get('/login')->assertRedirect('/account/pending');
    }

    public function test_json_registration_keeps_the_fortify_created_response(): void
    {
        $this->postJson('/register', [
            'name' => 'API Account',
            'email' => 'api-account@example.invalid',
            'password' => 'api-account-password-123',
            'password_confirmation' => 'api-account-password-123',
        ])->assertCreated();

        $this->assertDatabaseHas('users', ['email' => 'api-account@example.invalid']);
        $this->assertAuthenticated();
    }

    public function test_json_login_keeps_the_fortify_response(): void
    {
        $user = User::factory()->create();

        $this->postJson('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertOk()
            ->assertExactJson(['two_factor' => false]);

        $this->assertAuthenticatedAs($user);
    }

    public function test_pending_page_escapes_user_supplied_names(): void
    {
        $name = '<script>alert(1)</script>';
        $user = User::factory()->create(['name' => $name]);

        $this->actingAs($user)->get('/account/pending')
            ->assertOk()
            ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
            ->assertDontSee($name, false);
    }
}
