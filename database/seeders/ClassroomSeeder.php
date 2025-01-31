<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    public function run()
    {
        $classes = [
            ['class_level_id' => 2, 'stream' => 'A', 'capacity' => 30],
            ['class_level_id' => 3, 'stream' => 'A', 'capacity' => 30],
            ['class_level_id' => 4, 'stream' => 'A', 'capacity' => 30],
            ['class_level_id' => 5, 'stream' => 'A', 'capacity' => 30],
            ['class_level_id' => 6, 'stream' => 'A', 'capacity' => 30],
            ['class_level_id' => 7, 'stream' => 'A', 'capacity' => 30],
            ['class_level_id' => 8, 'stream' => 'A', 'capacity' => 30],
            ['class_level_id' => 9, 'stream' => 'A', 'capacity' => 30],
            ['class_level_id' => 10, 'stream' => 'A', 'capacity' => 30],
            ['class_level_id' => 11, 'stream' => 'A', 'capacity' => 30],
            ['class_level_id' => 12, 'stream' => 'A', 'capacity' => 30],
            // Add more as needed
        ];

        foreach ($classes as $class) {
            ClassRoom::create([
                'school_id' => 1,
                'class_level_id' => $class['class_level_id'],
                'stream' => $class['stream'],
                'capacity' => $class['capacity'],
                'status' => 'active'
            ]);
        }
    }
}