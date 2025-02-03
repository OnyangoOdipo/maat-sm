<?php

namespace Database\Seeders;

use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class TeacherSubjectSeeder extends Seeder
{
    public function run()
    {
        $assignments = [
            // Mathematics Teachers
            ['teacher_email' => 'teacher@school1.com', 'subject_code' => 'MATH', 'is_primary' => true],
            ['teacher_email' => 'teacher@school1.com', 'subject_code' => 'SCI', 'is_primary' => false],
            
            // Science Teacher
            ['teacher_email' => 'teacher2@school1.com', 'subject_code' => 'SCI', 'is_primary' => true],
            ['teacher_email' => 'teacher2@school1.com', 'subject_code' => 'MATH', 'is_primary' => false],
            
            // English Teacher
            ['teacher_email' => 'teacher3@school1.com', 'subject_code' => 'ENG', 'is_primary' => true],
            ['teacher_email' => 'teacher3@school1.com', 'subject_code' => 'SWAH', 'is_primary' => false],
            
            // Kiswahili Teacher
            ['teacher_email' => 'teacher4@school1.com', 'subject_code' => 'SWAH', 'is_primary' => true],
            ['teacher_email' => 'teacher4@school1.com', 'subject_code' => 'SS', 'is_primary' => false],
        ];

        foreach ($assignments as $assignment) {
            $teacher = Teacher::whereHas('user', function($query) use ($assignment) {
                $query->where('email', $assignment['teacher_email']);
            })->first();

            $subject = Subject::where('code', $assignment['subject_code'])->first();

            if ($teacher && $subject) {
                $teacher->subjects()->attach($subject->id, [
                    'is_primary' => $assignment['is_primary']
                ]);
            }
        }
    }
} 