<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Houses/Dormitories table
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->enum('gender', ['boys', 'girls', 'mixed']);
            $table->foreignId('house_parent_id')->nullable()->constrained('users');
            $table->text('description')->nullable();
            $table->integer('total_capacity');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Cubicles table
        Schema::create('cubicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('house_id')->constrained()->onDelete('cascade');
            $table->string('name'); // e.g., "Room 101"
            $table->integer('capacity');
            $table->enum('type', ['standard', 'prefect', 'special_needs', 'isolation']);
            $table->integer('floor_number')->default(1);
            $table->boolean('is_active')->default(true);
            $table->text('maintenance_notes')->nullable();
            $table->timestamps();
        });

        // Beds table
        Schema::create('beds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cubicle_id')->constrained()->onDelete('cascade');
            $table->string('bed_number');
            $table->boolean('is_occupied')->default(false);
            $table->boolean('needs_maintenance')->default(false);
            $table->text('maintenance_notes')->nullable();
            $table->timestamps();
        });

        // Bed Assignments table - tracks history of bed assignments
        Schema::create('bed_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bed_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->date('assigned_date');
            $table->date('end_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Boarding Leave Records
        Schema::create('boarding_leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->datetime('leave_time');
            $table->datetime('expected_return_time');
            $table->datetime('actual_return_time')->nullable();
            $table->string('reason');
            $table->string('guardian_contact');
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed']);
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('boarding_leaves');
        Schema::dropIfExists('bed_assignments');
        Schema::dropIfExists('beds');
        Schema::dropIfExists('cubicles');
        Schema::dropIfExists('houses');
    }
}; 