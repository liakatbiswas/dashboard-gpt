<?php

namespace App\Services\Access;

use App\Models\AccessSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleManagementService
{
    /** @param array{name:string, description?:?string, permissions?:array<int,int|string>} $data */
    public function save(?Role $role, array $data): Role
    {
        return DB::transaction(function () use ($role, $data): Role {
            AccessSetting::query()->lockForUpdate()->findOrFail(1);
            $record = $role ? Role::query()->lockForUpdate()->findOrFail($role->getKey()) : null;

            if ($record && in_array($record->name, config('access.protected_roles'), true) && $data['name'] !== $record->name) {
                throw ValidationException::withMessages(['name' => 'This system role cannot be renamed.']);
            }

            if (! $record && in_array($data['name'], config('access.protected_roles'), true)) {
                throw ValidationException::withMessages(['name' => 'This role name is reserved.']);
            }

            if (Role::query()->where('guard_name', 'web')->where('name', $data['name'])
                ->when($record, fn ($query) => $query->whereKeyNot($record->getKey()))->exists()) {
                throw ValidationException::withMessages(['name' => 'This role name is already in use.']);
            }

            if (! $record) {
                $record = Role::create(['name' => $data['name'], 'guard_name' => 'web']);
            }
            $record->update(['name' => $data['name'], 'description' => $data['description'] ?? null]);

            if ($record->name !== config('access.super_admin_role')) {
                $permissions = Permission::query()->where('guard_name', 'web')
                    ->whereIn('id', $data['permissions'] ?? [])->lockForUpdate()->get();
                if ($record->name === config('access.student_role')) {
                    $permissions->push(Permission::findByName('student.dashboard.view', 'web'));
                }
                $record->syncPermissions($permissions->unique('id'));
            }

            app(PermissionRegistrar::class)->forgetCachedPermissions();

            return $record;
        });
    }

    public function delete(Role $role): void
    {
        DB::transaction(function () use ($role): void {
            AccessSetting::query()->lockForUpdate()->findOrFail(1);
            $record = Role::query()->lockForUpdate()->findOrFail($role->getKey());

            if (in_array($record->name, config('access.protected_roles'), true)) {
                throw ValidationException::withMessages(['role' => 'This system role cannot be deleted.']);
            }
            if ($record->users()->exists()) {
                throw ValidationException::withMessages(['role' => 'This role is assigned to users. Remove those assignments before deleting it.']);
            }

            $record->delete();
            app(PermissionRegistrar::class)->forgetCachedPermissions();
        });
    }
}
