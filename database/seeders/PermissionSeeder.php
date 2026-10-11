<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $permissions = [

            /* Dashboard */
            'dashboard.view',
            'settings.view',
            'settings.update',
            'settings.upload_media',

            /* User Management */
            'user.view',
            'user.create',
            'user.update',
            'user.delete',
            'user.restore',
            'user.force-delete',
            'user.assign-role',

            /* Role Management */
            'role.view',
            'role.create',
            'role.update',
            'role.delete',

            /* Permission Management */
            'permission.view',
            'permission.create',
            'permission.update',
            'permission.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $this->command->info('Permission created successfully.');
    }
}
