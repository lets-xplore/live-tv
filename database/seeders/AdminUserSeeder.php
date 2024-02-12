<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // You can add multiple admin users in an array
        $adminUsers = [
            [
                'name' => 'Admin User 1',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'), // Hash the password
            ],
            [
                'name' => 'Admin User 2',
                'email' => 'admin@satori.com',
                'password' => Hash::make('admin12345'), // Hash the password
            ],
            // Add more admin users as needed
        ];

        // Insert the admin users into the 'admins' table
        DB::table('admins')->insert($adminUsers);
    }
}
