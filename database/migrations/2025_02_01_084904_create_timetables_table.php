<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->foreignId('class_level_id')->constrained()->onDelete('cascade');
            $table->string('term'); // First Term, Second Term, etc.
            $table->string('academic_year');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Ensure only one active timetable per class level per term
            $table->unique(['school_id', 'class_level_id', 'term', 'academic_year']);
        });

        Schema::create('timetable_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('timetable_id')->constrained()->onDelete('cascade');
            $table->foreignId('timeslot_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->foreignId('classroom_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Prevent double booking of teachers
            $table->unique(['timeslot_id', 'teacher_id']);
            // Prevent double booking of classrooms
            $table->unique(['timeslot_id', 'classroom_id']);
        });

        Schema::create('timetable_constraints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['teacher_unavailable', 'subject_max_per_day', 'preferred_time']);
            $table->foreignId('teacher_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('day')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->integer('max_per_day')->nullable();
            $table->integer('weight')->default(1); // Priority of the constraint
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('timetable_constraints');
        Schema::dropIfExists('timetable_slots');
        Schema::dropIfExists('timetables');
    }
}; 