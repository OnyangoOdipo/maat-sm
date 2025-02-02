<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('teacher_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->boolean('is_primary')->default(false); // Whether this is the teacher's main subject
            $table->timestamps();

            // A teacher can teach a subject only once
            $table->unique(['teacher_id', 'subject_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('teacher_subjects');
    }
}; 