<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class ProvisionSuperAdmin extends Command
{
    protected $signature = 'app:provision-super-admin';

    protected $description = 'Create the initial super-admin or securely rotate its password';

    public function handle(): int
    {
        if (! $this->input->isInteractive()) {
            $this->components->error('Run this command in an interactive terminal so the password can be entered securely.');

            return self::FAILURE;
        }

        $role = Role::query()
            ->where('name', 'super-admin')
            ->where('guard_name', 'web')
            ->first();

        if (! $role || ! $role->permissions()->exists()) {
            $this->components->error('The super-admin role is not ready. Run the permission and role seeders first.');

            return self::FAILURE;
        }

        $name = trim((string) $this->ask('Super-admin name'));
        $email = mb_strtolower(trim((string) $this->ask('Super-admin email')));

        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->components->error($error);
            }

            return self::FAILURE;
        }

        $existingUser = User::query()->where('email', $email)->first();
        $superAdminCount = User::role('super-admin', 'web')->count();

        if ($superAdminCount > 1) {
            $this->components->error('More than one super-admin already exists. Resolve the existing accounts before running this bootstrap command.');

            return self::FAILURE;
        }

        if ($existingUser && ! $existingUser->hasRole('super-admin', 'web')) {
            $this->components->error('That email already belongs to a non-super-admin account. Choose another email.');

            return self::FAILURE;
        }

        if ($superAdminCount === 1 && ! $existingUser) {
            $this->components->error('A super-admin already exists. Use that account to manage administrators.');

            return self::FAILURE;
        }

        if ($existingUser && ! $this->confirm('This super-admin already exists. Rotate its password now?', false)) {
            $this->components->info('No changes were made.');

            return self::SUCCESS;
        }

        $password = $this->secret('Enter a password with at least 15 characters');
        $passwordConfirmation = $this->secret('Confirm the password');

        $passwordValidator = Validator::make([
            'password' => $password,
            'password_confirmation' => $passwordConfirmation,
        ], [
            'password' => ['bail', 'required', 'string', Password::min(15)->uncompromised(), 'confirmed'],
        ]);

        if ($passwordValidator->fails()) {
            foreach ($passwordValidator->errors()->all() as $error) {
                $this->components->error($error);
            }

            return self::FAILURE;
        }

        DB::transaction(function () use ($existingUser, $name, $email, $password, $role): void {
            $user = $existingUser ?? new User;
            $user->name = $name;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->save();
            $user->syncRoles($role);
        });

        $this->components->info($existingUser
            ? 'The super-admin password was rotated successfully.'
            : 'The super-admin account was created successfully.');

        return self::SUCCESS;
    }
}
