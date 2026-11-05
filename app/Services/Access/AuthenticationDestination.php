<?php

namespace App\Services\Access;

use App\Models\User;

class AuthenticationDestination
{
    public function routeName(User $user): string
    {
        if ($user->isSuperAdmin()) {
            return 'dashboard';
        }

        if ($user->hasRole(config('access.student_role'), 'web') && $user->can('student.dashboard.view')) {
            return 'student.dashboard';
        }

        return 'account.pending';
    }

    public function url(User $user): string
    {
        return route($this->routeName($user));
    }
}
