<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('access.system_permissions') as $permission) {
            Permission::findOrCreate($permission, 'web');
        }
    }
}
