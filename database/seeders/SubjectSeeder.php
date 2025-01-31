<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    public function run()
    {
        $subjects = [
            ['name' => 'Mathematics', 'code' => 'MATH', 'subject_type' => 'core'],
            ['name' => 'English', 'code' => 'ENG', 'subject_type' => 'core'],
            ['name' => 'Kiswahili', 'code' => 'SWAH', 'subject_type' => 'core'],
            ['name' => 'Science', 'code' => 'SCI', 'subject_type' => 'core'],
            ['name' => 'Social Studies', 'code' => 'SS', 'subject_type' => 'core'],
            ['name' => 'Religious Education', 'code' => 'RE', 'subject_type' => 'core'],
            ['name' => 'Art', 'code' => 'ART', 'subject_type' => 'core'],
            ['name' => 'Music', 'code' => 'MUS', 'subject_type' => 'core'],
            ['name' => 'Physical Education', 'code' => 'PE', 'subject_type' => 'core'],
            ['name' => 'Health Education', 'code' => 'HE', 'subject_type' => 'core'],
        ];

        foreach ($subjects as $subject) {
            Subject::create([
                'school_id' => 1,
                'name' => $subject['name'],
                'code' => $subject['code'],
                'subject_type' => $subject['subject_type'],
                'status' => 'active'
            ]);
        }
    }
}