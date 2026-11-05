<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function update(User $user, Role $record): bool
    {
        return $user->isSuperAdmin() && $record->guard_name === 'web';
    }

    public function delete(User $user, Role $record): bool
    {
        return $user->isSuperAdmin() && $record->guard_name === 'web';
    }
}
