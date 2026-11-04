<?php

namespace App\Policies;

use App\Models\User;

class SiteSettingPolicy
{
    public function view(User $user): bool
    {
        return $user->hasPermissionTo('settings.view');
    }

    public function update(User $user): bool
    {
        return $user->hasPermissionTo('settings.update');
    }
}
