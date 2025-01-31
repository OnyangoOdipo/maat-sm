<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Class Levels
        Schema::create('class_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->foreignId('section_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->unsignedInteger('numeric_value');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['section_id', 'name']);
        });

        // Class Rooms
        Schema::create('class_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->foreignId('class_level_id')->constrained()->onDelete('cascade');
            $table->string('stream');
            $table->integer('capacity')->nullable();
            //$table->foreignId('class_teacher_id')->nullable()->constrained('teachers')->onDelete('set null');
            $table->string('room_number')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->unique(['class_level_id', 'stream']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('class_rooms');
        Schema::dropIfExists('class_levels');
    }
};