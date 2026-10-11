<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* Create Roles */
        $superAdmin = Role::findOrCreate('super-admin', 'web');
        $admin = Role::findOrCreate('admin', 'web');

        $superAdmin->syncPermissions(Permission::all());

        /* Admin */
        $admin->syncPermissions([
            'dashboard.view',

            // Users
            'user.view',
            'user.create',
            'user.update',
            'user.assign-role',
        ]);

        $this->command->info('Role created successfully.');

    }
}
