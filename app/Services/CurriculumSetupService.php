<?php

namespace App\Services;

use App\Models\School;
use App\Models\CurriculumType;
use App\Models\Section;
use App\Models\ClassLevel;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class CurriculumSetupService
{
    protected $curriculumConfigs;

    public function __construct()
    {
        $this->curriculumConfigs = json_decode(
            file_get_contents(database_path('seeders/data/curriculum_configurations.json')), 
            true
        );
    }

    public function setupCurriculum(School $school, array $selectedCurriculums)
    {
        \Log::info('Starting curriculum setup for school: ' . $school->id);
        
        DB::transaction(function () use ($school, $selectedCurriculums) {
            foreach ($selectedCurriculums as $curriculumCode) {
                \Log::info('Processing curriculum: ' . $curriculumCode);
                
                if (!isset($this->curriculumConfigs[$curriculumCode])) {
                    \Log::warning('Curriculum not found: ' . $curriculumCode);
                    continue;
                }

                $config = $this->curriculumConfigs[$curriculumCode];

                // Create or find Curriculum Type
                $curriculumType = CurriculumType::firstOrCreate(
                    [
                        'school_id' => $school->id,
                        'code' => $config['code']
                    ],
                    [
                        'name' => $config['name'],
                        'description' => $config['description'],
                        'is_active' => true,
                        'created_by' => auth()->id(),
                        'updated_by' => auth()->id()
                    ]
                );

                // Process each section
                foreach ($config['sections'] as $sectionData) {
                    $section = Section::firstOrCreate(
                        [
                            'school_id' => $school->id,
                            'name' => $sectionData['name']
                        ],
                        [
                            'curriculum_type_id' => $curriculumType->id
                        ]
                    );

                    $order = 1;
                    foreach ($sectionData['class_levels'] as $levelData) {
                        preg_match('/\d+/', $levelData['name'], $matches);
                        $numericValue = $matches[0] ?? $order;

                        $classLevel = ClassLevel::firstOrCreate(
                            [
                                'school_id' => $school->id,
                                'section_id' => $section->id,
                                'name' => $levelData['name']
                            ],
                            [
                                'numeric_value' => $numericValue,
                                'order' => $order,
                                'is_active' => true
                            ]
                        );

                        foreach ($levelData['subjects'] as $subjectData) {
                            // Generate a unique code for the school
                            $schoolSubjectCode = $school->id . '_' . $subjectData['code'];
                            
                            $subject = Subject::firstOrCreate(
                                [
                                    'school_id' => $school->id,
                                    'code' => $schoolSubjectCode
                                ],
                                [
                                    'name' => $subjectData['name'],
                                    'subject_type' => $subjectData['subject_type'],
                                    'status' => 'active'
                                ]
                            );

                            // Attach relationships
                            $subject->curriculumTypes()->syncWithoutDetaching([$curriculumType->id => ['is_compulsory' => $subjectData['is_compulsory']]]);
                            $subject->classLevels()->syncWithoutDetaching([$classLevel->id => ['is_compulsory' => $subjectData['is_compulsory']]]);
                        }
                        $order++;
                    }
                }
            }
        });
    }

    public function getAvailableCurriculums()
    {
        return collect($this->curriculumConfigs)->map(function ($config) {
            return [
                'code' => $config['code'],
                'name' => $config['name'],
                'description' => $config['description']
            ];
        });
    }
}