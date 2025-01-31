<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Schools Table
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->string('phone');
            $table->string('email')->unique();
            $table->enum('status', ['active', 'inactive', 'suspended']);
            $table->enum('subscription_status', ['trial', 'active', 'expired']);
            $table->timestamps();
            $table->softDeletes();
            //$table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            //$table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            //$table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('set null');
        });

        // Users Table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['superadmin', 'schooladmin', 'teacher', 'student', 'parent']);
            $table->foreignId('school_id')->nullable()->constrained()->onDelete('cascade');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('schools');
    }
};