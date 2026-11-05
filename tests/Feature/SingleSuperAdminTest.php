<?php

namespace Tests\Feature;

use App\Models\AccessSetting;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Contracts\Validation\UncompromisedVerifier;
use Tests\Concerns\CreatesSuperAdmin;
use Tests\TestCase;

class SingleSuperAdminTest extends TestCase
{
    use CreatesSuperAdmin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_a_second_user_with_owner_role_is_not_the_registered_owner(): void
    {
        $owner = $this->createSuperAdmin();
        $second = User::factory()->create();
        $second->assignRole('super-admin');

        $this->assertTrue($owner->isSuperAdmin());
        $this->assertFalse($second->isSuperAdmin());
        $this->actingAs($second)->get('/dashboard')->assertForbidden();
        $this->get('/roles')->assertForbidden();
        $this->get('/registration-settings')->assertForbidden();
    }

    public function test_setup_command_refuses_existing_owner_and_never_rotates_password(): void
    {
        $owner = $this->createSuperAdmin();
        $originalPassword = $owner->password;

        $this->artisan('app:provision-super-admin')
            ->expectsOutputToContain('setup-only command')
            ->assertFailed();

        $this->assertSame($originalPassword, $owner->fresh()->password);
        $this->assertSame(1, User::role('super-admin', 'web')->count());
        $this->assertSame($owner->id, AccessSetting::query()->findOrFail(1)->super_admin_user_id);
    }

    public function test_first_setup_creates_exactly_one_owner(): void
    {
        $this->app->instance(UncompromisedVerifier::class, new class implements UncompromisedVerifier
        {
            public function verify($data): bool
            {
                return true;
            }
        });

        $this->artisan('app:provision-super-admin')
            ->expectsQuestion('Super-admin name', 'School Owner')
            ->expectsQuestion('Super-admin email', 'owner@example.invalid')
            ->expectsQuestion('Enter a password with at least 15 characters', 'owner-bootstrap-password-123')
            ->expectsQuestion('Confirm the password', 'owner-bootstrap-password-123')
            ->assertSuccessful();

        $owner = User::query()->where('email', 'owner@example.invalid')->firstOrFail();
        $this->assertTrue($owner->isSuperAdmin());
        $this->assertSame(1, User::role('super-admin', 'web')->count());
        $this->artisan('app:provision-super-admin')->assertFailed();
        $this->assertSame(1, User::role('super-admin', 'web')->count());
    }

    public function test_upgrade_recognizes_the_existing_owner_without_changing_the_account(): void
    {
        $owner = $this->createSuperAdmin();
        $originalPassword = $owner->password;
        $migration = require glob(database_path('migrations/*create_access_settings_table.php'))[0];
        $migration->down();

        $migration->up();

        $this->assertSame($owner->id, AccessSetting::query()->findOrFail(1)->super_admin_user_id);
        $this->assertSame($originalPassword, $owner->fresh()->password);
        $this->assertTrue($owner->fresh()->isSuperAdmin());
        $this->actingAs($owner)->get('/roles')->assertOk();
    }

    public function test_migration_refuses_multiple_existing_owners_without_selecting_one(): void
    {
        $owner = $this->createSuperAdmin();
        $second = User::factory()->create();
        $second->assignRole('super-admin');
        $migration = require glob(database_path('migrations/*create_access_settings_table.php'))[0];

        try {
            $migration->up();
            $this->fail('Multiple existing owners must be resolved explicitly.');
        } catch (\RuntimeException $exception) {
            $this->assertStringContainsString('More than one super-admin', $exception->getMessage());
        }

        $this->assertSame($owner->id, AccessSetting::query()->findOrFail(1)->super_admin_user_id);
        $this->assertSame(2, User::role('super-admin', 'web')->count());
    }
}
