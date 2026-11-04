<?php

namespace App\Repositories\Settings;

use App\Models\SiteSetting;

class SiteSettingRepository implements SiteSettingRepositoryInterface
{
    public function getSettings(): SiteSetting
    {
        return SiteSetting::query()->firstOrCreate(['id' => 1]);
    }

    public function update(array $data): SiteSetting
    {
        $settings = $this->getSettings();
        $settings->update($data);

        return $settings->fresh();
    }
}
