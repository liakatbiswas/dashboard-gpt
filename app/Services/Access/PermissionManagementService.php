<?php

namespace App\Services\Access;

use App\Models\AccessSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionManagementService
{
    /** @param array{name:string, description?:?string} $data */
    public function save(?Permission $permission, array $data): Permission
    {
        return DB::transaction(function () use ($permission, $data): Permission {
            AccessSetting::query()->lockForUpdate()->findOrFail(1);
            $record = $permission ? Permission::query()->lockForUpdate()->findOrFail($permission->getKey()) : null;

            if ($record && in_array($record->name, config('access.system_permissions'), true) && $data['name'] !== $record->name) {
                throw ValidationException::withMessages(['name' => 'This system permission cannot be renamed.']);
            }

            if (Permission::query()->where('guard_name', 'web')->where('name', $data['name'])
                ->when($record, fn ($query) => $query->whereKeyNot($record->getKey()))->exists()) {
                throw ValidationException::withMessages(['name' => 'This permission name is already in use.']);
            }

            if (! $record) {
                $record = Permission::create(['name' => $data['name'], 'guard_name' => 'web']);
            }
            $record->update(['name' => $data['name'], 'description' => $data['description'] ?? null]);
            app(PermissionRegistrar::class)->forgetCachedPermissions();

            return $record;
        });
    }

    public function delete(Permission $permission): void
    {
        DB::transaction(function () use ($permission): void {
            AccessSetting::query()->lockForUpdate()->findOrFail(1);
            $record = Permission::query()->lockForUpdate()->findOrFail($permission->getKey());

            if (in_array($record->name, config('access.system_permissions'), true)) {
                throw ValidationException::withMessages(['permission' => 'This system permission cannot be deleted.']);
            }

            $record->delete();
            app(PermissionRegistrar::class)->forgetCachedPermissions();
        });
    }
}
