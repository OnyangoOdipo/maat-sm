<?php

namespace Database\Seeders;

use App\Models\ClassLevel;
use Illuminate\Database\Seeder;

class ClassLevelSeeder extends Seeder
{
    public function run()
    {
        $levels = [
            ['section_id' => 1, 'name' => 'Pre-School 1', 'numeric_value' => 0],
            ['section_id' => 2, 'name' => 'Grade 1', 'numeric_value' => 1],
            ['section_id' => 2, 'name' => 'Grade 2', 'numeric_value' => 2],
            ['section_id' => 2, 'name' => 'Grade 3', 'numeric_value' => 3],
            ['section_id' => 3, 'name' => 'Grade 4', 'numeric_value' => 4],
            ['section_id' => 3, 'name' => 'Grade 5', 'numeric_value' => 5],
            ['section_id' => 3, 'name' => 'Grade 6', 'numeric_value' => 6],
            ['section_id' => 4, 'name' => 'Grade 7', 'numeric_value' => 7],
            ['section_id' => 4, 'name' => 'Grade 8', 'numeric_value' => 8],
            ['section_id' => 4, 'name' => 'Grade 9', 'numeric_value' => 9],
            ['section_id' => 5, 'name' => 'Grade 10', 'numeric_value' => 10],
            ['section_id' => 5, 'name' => 'Grade 11', 'numeric_value' => 11],
            ['section_id' => 5, 'name' => 'Grade 12', 'numeric_value' => 12]
        ];

        foreach ($levels as $level) {
            ClassLevel::create([
                'school_id' => 1,
                'section_id' => $level['section_id'],
                'name' => $level['name'],
                'numeric_value' => $level['numeric_value'],
                'order' => $level['numeric_value'],
                'is_active' => true
            ]);
        }
    }
}