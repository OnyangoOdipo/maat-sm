<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('class_level_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_level_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->integer('lessons_per_week')->default(1);
            $table->boolean('is_compulsory')->default(true);
            $table->timestamps();

            // A subject can be assigned to a class level only once
            $table->unique(['class_level_id', 'subject_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('class_level_subjects');
    }
}; 