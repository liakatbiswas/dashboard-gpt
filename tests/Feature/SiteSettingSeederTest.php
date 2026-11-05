<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use Database\Seeders\SiteSettingSeeder;
use Tests\TestCase;

class SiteSettingSeederTest extends TestCase
{
    public function test_seeding_does_not_overwrite_saved_site_settings(): void
    {
        $this->seed(SiteSettingSeeder::class);

        $setting = SiteSetting::query()->firstOrFail();
        $setting->update(['site_title' => 'Custom site title']);

        $this->seed(SiteSettingSeeder::class);

        $this->assertSame('Custom site title', $setting->fresh()->site_title);
    }
}
