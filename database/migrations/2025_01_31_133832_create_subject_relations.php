<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Subjects
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->enum('subject_type', ['core', 'elective', 'optional'])->default('core');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Pivot Tables
        Schema::create('curriculum_type_subject', function (Blueprint $table) {
            $table->foreignId('curriculum_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->boolean('is_compulsory')->default(true);
            $table->timestamps();
        });

        Schema::create('class_level_subject', function (Blueprint $table) {
            $table->foreignId('class_level_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->boolean('is_compulsory')->default(true);
            $table->timestamps();
        });

        Schema::create('subject_teacher', function (Blueprint $table) {
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subject_teacher');
        Schema::dropIfExists('class_level_subject');
        Schema::dropIfExists('curriculum_type_subject');
        Schema::dropIfExists('subjects');
    }
};