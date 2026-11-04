<?php

namespace App\Repositories\Settings;

use App\Models\SiteSetting;

interface SiteSettingRepositoryInterface
{
    public function getSettings(): SiteSetting;

    public function update(array $data): SiteSetting;
}
