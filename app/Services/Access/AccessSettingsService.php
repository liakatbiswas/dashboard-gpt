<?php

namespace App\Services\Access;

use App\Models\AccessSetting;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AccessSettingsService
{
    public function get(): AccessSetting
    {
        return AccessSetting::query()->findOrFail(1);
    }

    public function isSuperAdmin(User $user): bool
    {
        return $user->hasRole(config('access.super_admin_role'), 'web')
            && $this->get()->super_admin_user_id === $user->getKey();
    }

    public function registrationIsOpen(): bool
    {
        return $this->get()->student_registration_enabled;
    }

    public function updateRegistration(bool $enabled, User $actor): void
    {
        abort_unless($this->isSuperAdmin($actor), 403);

        DB::transaction(function () use ($enabled, $actor): void {
            $setting = AccessSetting::query()->lockForUpdate()->findOrFail(1);
            $setting->update(['student_registration_enabled' => $enabled, 'updated_by' => $actor->getKey()]);
        });
    }
}
