<?php

namespace App\Console\Commands;

use App\Models\AccessSetting;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use RuntimeException;
use Spatie\Permission\Models\Role;

class ProvisionSuperAdmin extends Command
{
    protected $signature = 'app:provision-super-admin';

    protected $description = 'Create the single initial super-admin; existing accounts and passwords are never replaced';

    public function handle(): int
    {
        $settings = AccessSetting::query()->find(1);
        $role = Role::query()->where('name', config('access.super_admin_role'))->where('guard_name', 'web')->first();

        if (! $settings || ! $role || ! $role->permissions()->exists()) {
            $this->components->error('Run migrations and the permission/role seeders first.');

            return self::FAILURE;
        }
        if ($settings->super_admin_user_id !== null || $role->users()->exists()) {
            $this->components->error('A super-admin already exists. This setup-only command cannot create another owner or reset a password.');

            return self::FAILURE;
        }
        if (! $this->input->isInteractive()) {
            $this->components->error('Run this command in an interactive terminal to enter the initial credentials securely.');

            return self::FAILURE;
        }

        $name = trim((string) $this->ask('Super-admin name'));
        $email = mb_strtolower(trim((string) $this->ask('Super-admin email')));
        $validator = Validator::make(['name' => $name, 'email' => $email], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->components->error($error);
            }

            return self::FAILURE;
        }

        $password = $this->secret('Enter a password with at least 15 characters');
        $confirmation = $this->secret('Confirm the password');
        $validator = Validator::make(['password' => $password, 'password_confirmation' => $confirmation], [
            'password' => ['required', 'string', Password::min(15)->uncompromised(), 'confirmed'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->components->error($error);
            }

            return self::FAILURE;
        }

        try {
            DB::transaction(function () use ($name, $email, $password, $role): void {
                $settings = AccessSetting::query()->lockForUpdate()->findOrFail(1);
                $ownerRole = Role::query()->lockForUpdate()->findOrFail($role->getKey());
                if ($settings->super_admin_user_id !== null || $ownerRole->users()->exists()) {
                    throw new RuntimeException('A super-admin was created already. No account or password was changed.');
                }

                if (User::query()->where('email', $email)->exists()) {
                    throw new RuntimeException('That email was registered already. Choose a new email for the initial owner.');
                }

                $user = User::create(['name' => $name, 'email' => $email, 'password' => Hash::make($password)]);
                $user->syncRoles([$ownerRole]);
                $settings->update(['super_admin_user_id' => $user->getKey()]);
            });
        } catch (RuntimeException $exception) {
            $this->components->error($exception->getMessage());

            return self::FAILURE;
        }

        $this->components->info('The single super-admin account was created successfully.');

        return self::SUCCESS;
    }
}
