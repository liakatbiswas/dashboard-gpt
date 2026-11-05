<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Concerns\CreatesSuperAdmin;
use Tests\TestCase;

class SiteSettingsAccessTest extends TestCase
{
    use CreatesSuperAdmin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_owner_can_save_text_settings(): void
    {
        $owner = $this->createSuperAdmin();

        $this->actingAs($owner)->from('/settings')->put('/settings', ['site_title' => 'Updated School'])
            ->assertRedirect('/settings')->assertSessionHas('success');

        $this->assertDatabaseHas('site_settings', ['site_title' => 'Updated School', 'updated_by' => $owner->id]);
    }

    public function test_student_with_settings_permissions_still_cannot_enter_owner_pages(): void
    {
        $student = User::factory()->create();
        $student->assignRole('student');
        $student->givePermissionTo(['settings.view', 'settings.update', 'settings.upload_media']);

        $this->actingAs($student)->get('/settings')->assertForbidden();
        $this->put('/settings', ['site_title' => 'Not allowed'])->assertForbidden();
        $this->assertDatabaseMissing('site_settings', ['site_title' => 'Not allowed']);
    }

    public function test_owner_can_upload_a_logo(): void
    {
        Storage::fake('public');
        $this->actingAs($this->createSuperAdmin())->put('/settings', [
            'site_title' => 'School with logo', 'light_logo' => UploadedFile::fake()->image('logo.png'),
        ])->assertRedirect()->assertSessionHas('success');

        $path = SiteSetting::query()->firstOrFail()->light_logo_path;
        Storage::disk('public')->assertExists($path);
    }

    public function test_validation_errors_are_visible_next_to_their_fields(): void
    {
        $this->actingAs($this->createSuperAdmin())->from('/settings')
            ->put('/settings', ['site_title' => ''])
            ->assertRedirect('/settings')->assertSessionHasErrors('site_title');

        $this->withCookie(config('session.cookie'), session()->getId())->get('/settings')
            ->assertOk()->assertSee('The site title field is required.')
            ->assertSee('aria-describedby="site_title-error"', false);
    }

    public function test_settings_require_the_owner_even_for_a_legacy_admin(): void
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $this->actingAs($user)->get('/settings')->assertForbidden();
        $this->get('/dashboard')->assertForbidden();
    }

    public function test_phone_longer_than_database_column_is_rejected(): void
    {
        $this->actingAs($this->createSuperAdmin())->put('/settings', [
            'site_title' => 'School', 'phone' => str_repeat('1', 31),
        ])->assertSessionHasErrors('phone');
    }
}
