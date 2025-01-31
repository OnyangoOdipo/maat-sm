<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'name' => 'Jane Student',
            'email' => 'student@school1.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'school_id' => 1
        ]);

        Student::create([
            'user_id' => $user->id,
            'school_id' => 1,
            'class_room_id' => 1,
            'admission_number' => 'STD-001',
            'roll_number' => '1',
            'date_of_birth' => '2015-05-15',
            'gender' => 'female',
            'address' => '456 Student Road',
            'phone' => '0712345679',
            'parent_name' => 'Mary Parent',
            'parent_phone' => '0712345680',
            'parent_relationship' => 'mother',
            'admission_date' => now()->subYear(),
            'status' => 'active'
        ]);

        $user = User::create([
            'name' => 'John Student',
            'email' => 'student2@school1.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'school_id' => 1
        ]);

        Student::create([
            'user_id' => $user->id,
            'school_id' => 1,
            'class_room_id' => 2,
            'admission_number' => 'STD-002',
            'roll_number' => '2',
            'date_of_birth' => '2016-06-16',
            'gender' => 'male',
            'address' => '789 Student Road',
            'phone' => '0712345681',
            'parent_name' => 'John Parent',
            'parent_phone' => '0712345682',
            'parent_relationship' => 'father',
            'admission_date' => now()->subYear(),
            'status' => 'active'
        ]);

        $user = User::create([
            'name' => 'Alice Student',
            'email' => 'student3@school1.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'school_id' => 1
        ]);

        Student::create([
            'user_id' => $user->id,
            'school_id' => 1,
            'class_room_id' => 3,
            'admission_number' => 'STD-003',
            'roll_number' => '3',
            'date_of_birth' => '2017-07-17',
            'gender' => 'female',
            'address' => '123 Student Road',
            'phone' => '0712345683',
            'parent_name' => 'Alice Parent',
            'parent_phone' => '0712345684',
            'parent_relationship' => 'mother',
            'admission_date' => now()->subYear(),
            'status' => 'active'
        ]);

        $user = User::create([
            'name' => 'Bob Student',
            'email' => 'student4@school1.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'school_id' => 1
        ]);

        Student::create([
            'user_id' => $user->id,
            'school_id' => 1,
            'class_room_id' => 4,
            'admission_number' => 'STD-004',
            'roll_number' => '4',
            'date_of_birth' => '2018-08-18',
            'gender' => 'male',
            'address' => '456 Student Road',
            'phone' => '0712345685',
            'parent_name' => 'Bob Parent',
            'parent_phone' => '0712345686',
            'parent_relationship' => 'father',
            'admission_date' => now()->subYear(),
            'status' => 'active'
        ]);
    }
}