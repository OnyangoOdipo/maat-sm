<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    public function run()
    {
        $sections = [
            ['name' => 'Pre-Primary', 'code' => 'PP', 'order' => 1],
            ['name' => 'Lower Primary', 'code' => 'LP', 'order' => 2],
            ['name' => 'Upper Primary', 'code' => 'UP', 'order' => 3],
            ['name' => 'Junior Secondary', 'code' => 'JS', 'order' => 4],
            ['name' => 'Senior Secondary', 'code' => 'SS', 'order' => 5]
        ];

        foreach ($sections as $section) {
            Section::create([
                'school_id' => 1,
                'curriculum_type_id' => 1, // CBC
                'name' => $section['name'],
                'code' => $section['code'],
                'order' => $section['order'],
                'is_active' => true
            ]);
        }
    }
}