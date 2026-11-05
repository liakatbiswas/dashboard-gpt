<?php

namespace Tests\Concerns;

use App\Models\AccessSetting;
use App\Models\User;
use Spatie\Permission\Models\Role;

trait CreatesSuperAdmin
{
    protected function createSuperAdmin(): User
    {
        $setting = AccessSetting::query()->findOrFail(1);
        if ($setting->super_admin_user_id !== null) {
            throw new \LogicException('This test already has a Super Admin.');
        }

        $user = User::factory()->create();
        $user->syncRoles([Role::findOrCreate('super-admin', 'web')]);
        $setting->update(['super_admin_user_id' => $user->getKey()]);

        return $user;
    }
}
