<?php

namespace Database\Seeders;

use App\Models\CurriculumType;
use Illuminate\Database\Seeder;

class CurriculumTypeSeeder extends Seeder
{
    public function run()
    {
        CurriculumType::create([
            'school_id' => 1,
            'name' => 'CBC',
            'code' => 'CBC',
            'description' => 'Competency Based Curriculum',
            'is_active' => true,
            'created_by' => 1,
            'updated_by' => 1
        ]);
    }
}