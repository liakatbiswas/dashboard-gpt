<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        /* Create Super Admin User */
        $superAdmin = User::firstOrCreate(
            [
                'email' => 'liakatbiswas@gmail.com',
            ],
            [
                'name' => 'Liakat Biswas',
                'password' => Hash::make('12345'),
            ]
        );

        $superAdmin->syncRoles('super-admin');

        /* Seeder Success Message */
        $this->command->info('Users created and roles assigned successfully.');

    }
}
