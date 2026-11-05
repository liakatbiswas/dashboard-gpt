<?php

namespace App\Actions\Fortify;

use App\Models\AccessSetting;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Spatie\Permission\Models\Role;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /** @param array<string, string> $input */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
            'password' => $this->passwordRules(),
        ])->validate();

        return DB::transaction(function () use ($input): User {
            $settings = AccessSetting::query()->lockForUpdate()->findOrFail(1);
            abort_unless($settings->student_registration_enabled, 403, 'Student registration is currently closed.');

            $role = Role::findByName(config('access.student_role'), 'web');
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);
            $user->syncRoles([$role]);

            return $user;
        });
    }
}
