<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function update(User $user, Permission $record): bool
    {
        return $user->isSuperAdmin() && $record->guard_name === 'web';
    }

    public function delete(User $user, Permission $record): bool
    {
        return $user->isSuperAdmin() && $record->guard_name === 'web';
    }
}
