<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'teacher@school1.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'school_id' => 1
        ]);

        Teacher::create([
            'user_id' => $user->id,
            'school_id' => 1,
            'employee_number' => 'TCH-001',
            'date_of_birth' => '1980-01-01',
            'gender' => 'male',
            'address' => '123 Teacher Street',
            'phone' => '0712345678',
            'qualification' => 'B.Ed',
            'specialization' => 'Mathematics',
            'joining_date' => now()->subYears(5),
            'status' => 'active'
        ]);

        $user = User::create([
            'name' => 'Jane Doe',
            'email' => 'teacher2@school1.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'school_id' => 1
        ]);

        Teacher::create([
            'user_id' => $user->id,
            'school_id' => 1,
            'employee_number' => 'TCH-002',
            'date_of_birth' => '1985-05-15',
            'gender' => 'female',
            'address' => '456 Teacher Lane',
            'phone' => '0789012345',
            'qualification' => 'M.Ed',
            'specialization' => 'Science',
            'joining_date' => now()->subYears(3),
            'status' => 'active'
        ]);

        $user = User::create([
            'name' => 'Alice Doe',
            'email' => 'teacher3@school1.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'school_id' => 1
        ]);

        Teacher::create([
            'user_id' => $user->id,
            'school_id' => 1,
            'employee_number' => 'TCH-003',
            'date_of_birth' => '1990-07-20',
            'gender' => 'female',
            'address' => '789 Teacher Road',
            'phone' => '0711223344',
            'qualification' => 'Ph.D',
            'specialization' => 'History',
            'joining_date' => now()->subYears(2),
            'status' => 'active'
        ]);

        $user = User::create([
            'name' => 'Bob Doe',
            'email' => 'teacher4@school1.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'school_id' => 1
        ]);

        Teacher::create([
            'user_id' => $user->id,
            'school_id' => 1,
            'employee_number' => 'TCH-004',
            'date_of_birth' => '1982-03-10',
            'gender' => 'male',
            'address' => '101 Teacher Avenue',
            'phone' => '0723456789',
            'qualification' => 'B.A',
            'specialization' => 'English',
            'joining_date' => now()->subYears(4),
            'status' => 'active'
        ]);
    }
}
