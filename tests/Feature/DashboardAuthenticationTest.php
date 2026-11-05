<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Laravel\Sanctum\Sanctum;
use PragmaRX\Google2FA\Google2FA;
use Tests\TestCase;

class DashboardAuthenticationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    private function twoFactorUser(): User
    {
        $user = User::factory()->create()->forceFill([
            'two_factor_secret' => encrypt('JBSWY3DPEHPK3PXP'),
            'two_factor_recovery_codes' => encrypt(json_encode(['test-recovery-one', 'test-recovery-two'])),
            'two_factor_confirmed_at' => now(),
        ]);
        $user->save();

        return $user;
    }

    public function test_api_user_does_not_expose_two_factor_secrets(): void
    {
        Sanctum::actingAs($this->twoFactorUser());

        $data = $this->getJson('/api/user')->assertOk()->json();

        $this->assertArrayNotHasKey('two_factor_secret', $data);
        $this->assertArrayNotHasKey('two_factor_recovery_codes', $data);
        $this->assertArrayNotHasKey('password', $data);
    }

    public function test_password_confirmation_renders_and_accepts_the_current_password(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/user/confirm-password')
            ->assertOk()
            ->assertSee('name="_token"', false);

        $this->post('/user/confirm-password', ['password' => 'password'])
            ->assertRedirect()
            ->assertSessionHas('auth.password_confirmed_at');
    }

    public function test_password_confirmation_rejects_an_incorrect_password(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/user/confirm-password', ['password' => 'incorrect'])
            ->assertSessionHasErrors('password');
    }

    public function test_confirmed_two_factor_user_must_complete_the_challenge(): void
    {
        $user = $this->twoFactorUser();

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect('/two-factor-challenge');
        $this->assertGuest();

        $this->get('/two-factor-challenge')->assertOk();
        $code = (new Google2FA)->getCurrentOtp('JBSWY3DPEHPK3PXP');

        $this->post('/two-factor-challenge', ['code' => $code])
            ->assertRedirect('/account/pending');
        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_two_factor_code_does_not_authenticate(): void
    {
        $user = $this->twoFactorUser();

        $this->post('/login', ['email' => $user->email, 'password' => 'password']);
        $this->post('/two-factor-challenge', ['code' => 'invalid-code'])
            ->assertSessionHasErrors('code');
        $this->assertGuest();
    }

    public function test_two_factor_json_login_keeps_the_fortify_no_content_response(): void
    {
        $user = $this->twoFactorUser();

        $this->post('/login', ['email' => $user->email, 'password' => 'password']);
        $code = (new Google2FA)->getCurrentOtp('JBSWY3DPEHPK3PXP');

        $this->postJson('/two-factor-challenge', ['code' => $code])->assertNoContent();
        $this->assertAuthenticatedAs($user);
    }

    public function test_recovery_code_can_only_be_used_once(): void
    {
        $user = $this->twoFactorUser();

        $this->post('/login', ['email' => $user->email, 'password' => 'password']);
        $this->post('/two-factor-challenge', ['recovery_code' => 'test-recovery-one'])
            ->assertRedirect('/account/pending');
        $this->assertAuthenticatedAs($user);
        $this->assertNotContains('test-recovery-one', $user->fresh()->recoveryCodes());
    }

    public function test_invalid_recovery_code_shows_feedback_without_authenticating(): void
    {
        $user = $this->twoFactorUser();

        $this->post('/login', ['email' => $user->email, 'password' => 'password']);
        $this->post('/two-factor-challenge', ['recovery_code' => 'invalid-recovery'])
            ->assertSessionHasErrors('recovery_code');
        $this->assertGuest();
        $this->withCookie(config('session.cookie'), session()->getId())
            ->get('/two-factor-challenge')
            ->assertOk()
            ->assertSee('The provided two factor recovery code was invalid.')
            ->assertSee('open', false);
    }

    public function test_admin_dashboard_has_logout_token_and_logout_succeeds(): void
    {
        $this->seed(DatabaseSeeder::class);
        $user = User::factory()->create();
        $user->assignRole('admin');

        $this->actingAs($user)->get('/dashboard')
            ->assertOk()
            ->assertSee('name="_token"', false)
            ->assertDontSee('href="'.route('settings.edit').'"', false);

        app()['env'] = 'local';
        $this->withSession(['_token' => 'test-logout-token'])
            ->post('/logout', ['_token' => 'test-logout-token'])
            ->assertRedirect();
        $this->assertGuest();
    }

    public function test_dashboard_requires_authentication_and_permission(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
        $this->seed(DatabaseSeeder::class);
        $this->actingAs(User::factory()->create())->get('/dashboard')->assertForbidden();
    }
}
