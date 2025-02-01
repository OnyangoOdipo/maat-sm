<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('timeslots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->foreignId('class_level_id')->constrained()->onDelete('cascade');
            $table->string('day');  // Monday, Tuesday, etc.
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('type', ['regular', 'break', 'lunch', 'assembly']);
            $table->integer('slot_number');
            $table->boolean('is_break')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Prevent overlapping timeslots for the same class level and day
            $table->unique(['school_id', 'class_level_id', 'day', 'start_time']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('timeslots');
    }
}; 