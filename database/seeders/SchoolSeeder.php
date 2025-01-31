<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SchoolSeeder extends Seeder
{
    public function run()
    {

        // Create default school
        $school = School::create([
            'name' => 'Demo School',
            'address' => '123 School Street',
            'phone' => '+1234567890',
            'email' => 'contact@demoschool.com',
            'status' => 'active',
            'subscription_status' => 'active' 
        ]);

    }
} 