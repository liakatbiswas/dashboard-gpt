<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $owner = Role::findOrCreate(config('access.super_admin_role'), 'web');
        $owner->givePermissionTo(Permission::query()->where('guard_name', 'web')->get());

        $student = Role::findOrCreate(config('access.student_role'), 'web');
        $student->givePermissionTo(Permission::findOrCreate('student.dashboard.view', 'web'));

        $legacyAdmin = Role::findOrCreate('admin', 'web');
        if ($legacyAdmin->wasRecentlyCreated) {
            $legacyAdmin->givePermissionTo([
                'dashboard.view', 'user.view', 'user.create', 'user.update', 'user.assign-role',
            ]);
        }

        User::query()->doesntHave('roles')->chunkById(100, function (Collection $users) use ($student): void {
            foreach ($users as $user) {
                $user->assignRole($student);
            }
        });
    }
}
