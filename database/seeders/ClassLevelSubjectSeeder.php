<?php

namespace Database\Seeders;

use App\Models\ClassLevel;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class ClassLevelSubjectSeeder extends Seeder
{
    public function run()
    {
        $assignments = [
            // Grade 7 subjects
            ['class_name' => 'Grade 7', 'subject_code' => 'MATH', 'lessons_per_week' => 6],
            ['class_name' => 'Grade 7', 'subject_code' => 'ENG', 'lessons_per_week' => 5],
            ['class_name' => 'Grade 7', 'subject_code' => 'SWAH', 'lessons_per_week' => 4],
            ['class_name' => 'Grade 7', 'subject_code' => 'SCI', 'lessons_per_week' => 5],
            
            // Grade 8 subjects
            ['class_name' => 'Grade 8', 'subject_code' => 'MATH', 'lessons_per_week' => 6],
            ['class_name' => 'Grade 8', 'subject_code' => 'ENG', 'lessons_per_week' => 5],
            ['class_name' => 'Grade 8', 'subject_code' => 'SWAH', 'lessons_per_week' => 4],
            ['class_name' => 'Grade 8', 'subject_code' => 'SCI', 'lessons_per_week' => 5],
        ];

        foreach ($assignments as $assignment) {
            $classLevel = ClassLevel::where('name', $assignment['class_name'])->first();
            $subject = Subject::where('code', $assignment['subject_code'])->first();

            if ($classLevel && $subject) {
                $classLevel->subjects()->attach($subject->id, [
                    'lessons_per_week' => $assignment['lessons_per_week'],
                    'is_compulsory' => true
                ]);
            }
        }
    }
} 