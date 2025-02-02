<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
public function run()
{
    $this->call([
        //SchoolSeeder::class,
        //UsersTableSeeder::class,
        //CurriculumTypeSeeder::class,
        //SectionSeeder::class,
        //ClassLevelSeeder::class,
        //ClassroomSeeder::class, // Must come BEFORE StudentSeeder
       // TeacherSeeder::class,
       // SubjectSeeder::class,
       // StudentSeeder::class,
        TeacherSubjectSeeder::class,
        ClassLevelSubjectSeeder::class,
    ]);
}
}
