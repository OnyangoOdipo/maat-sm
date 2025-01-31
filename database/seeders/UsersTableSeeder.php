<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Create Superadmin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin'
        ]);

        // Create School Admin
        User::create([
            'name' => 'School Admin',
            'email' => 'schooladmin@example.com',
            'password' => Hash::make('password'),
            'role' => 'schooladmin'
        ]);

        // Create Teacher
        User::create([
            'name' => 'Teacher',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password'),
            'role' => 'teacher'
        ]);
    }
}