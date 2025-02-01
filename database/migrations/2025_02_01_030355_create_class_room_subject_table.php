<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('class_room_subject', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_room_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('teacher_id')->nullable()->constrained()->onDelete('set null');
            $table->boolean('is_compulsory')->default(true);
            $table->timestamps();

            // Prevent duplicate subject assignments to the same class
            $table->unique(['class_room_id', 'subject_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('class_room_subject');
    }
}; 