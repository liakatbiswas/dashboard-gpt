<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class SiteSettingsAccessTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        $this->seed(DatabaseSeeder::class);
    }

    private function userWithPermissions(array $permissions): User
    {
        $user = User::factory()->create();
        $user->givePermissionTo($permissions);

        return $user;
    }

    public function test_text_settings_can_be_saved_without_media_permission(): void
    {
        $user = $this->userWithPermissions(['settings.update']);

        $this->actingAs($user)->from('/settings')
            ->put('/settings', ['site_title' => 'Updated School'])
            ->assertRedirect('/settings')
            ->assertSessionHas('success');

        $this->assertDatabaseHas('site_settings', ['site_title' => 'Updated School', 'updated_by' => $user->id]);
    }

    public static function mediaFields(): array
    {
        return [
            'favicon' => ['favicon'],
            'light logo' => ['light_logo'],
            'dark logo' => ['dark_logo'],
        ];
    }

    #[DataProvider('mediaFields')]
    public function test_media_upload_requires_its_own_permission(string $field): void
    {
        Storage::fake('public');
        $original = SiteSetting::query()->firstOrFail()->getAttributes();

        $this->actingAs($this->userWithPermissions(['settings.update']))
            ->put('/settings', [
                'site_title' => 'Unauthorized change',
                $field => UploadedFile::fake()->image('image.png'),
            ])
            ->assertForbidden();

        $this->assertSame($original, SiteSetting::query()->firstOrFail()->getAttributes());
        $this->assertSame([], Storage::disk('public')->allFiles('site-settings'));
    }

    public function test_authorized_media_upload_is_saved(): void
    {
        Storage::fake('public');
        $user = $this->userWithPermissions(['settings.update', 'settings.upload_media']);

        $this->actingAs($user)->put('/settings', [
            'site_title' => 'School with logo',
            'light_logo' => UploadedFile::fake()->image('logo.png'),
        ])->assertRedirect()->assertSessionHas('success');

        $path = SiteSetting::query()->firstOrFail()->light_logo_path;
        $this->assertStringStartsWith('site-settings/', $path);
        Storage::disk('public')->assertExists($path);
    }

    public function test_validation_errors_are_visible_next_to_their_fields(): void
    {
        $this->actingAs($this->userWithPermissions(['settings.view', 'settings.update']))
            ->from('/settings')
            ->put('/settings', ['site_title' => ''])
            ->assertRedirect('/settings')
            ->assertSessionHasErrors('site_title');

        $response = $this->withCookie(config('session.cookie'), session()->getId())->get('/settings');
        $response->assertOk()
            ->assertSee('The site title field is required.')
            ->assertSee('aria-describedby="site_title-error"', false)
            ->assertSee('aria-invalid="true"', false);
    }

    public function test_view_only_user_cannot_save_and_has_disabled_controls(): void
    {
        $this->actingAs($this->userWithPermissions(['settings.view']))
            ->get('/settings')
            ->assertOk()
            ->assertSee('You have permission to view these settings.')
            ->assertSee('disabled', false)
            ->assertDontSee('Save settings');

        $this->put('/settings', ['site_title' => 'Not allowed'])->assertForbidden();
    }

    public function test_settings_are_inaccessible_without_permission(): void
    {
        $this->actingAs(User::factory()->create())->get('/settings')->assertForbidden();
        $this->put('/settings', ['site_title' => 'Not allowed'])->assertForbidden();
    }

    public function test_phone_longer_than_database_column_is_rejected(): void
    {
        $this->actingAs($this->userWithPermissions(['settings.update']))
            ->put('/settings', ['site_title' => 'School', 'phone' => str_repeat('1', 31)])
            ->assertSessionHasErrors('phone');
    }
}
