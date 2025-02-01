<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('teachers', function (Blueprint $table) {
            // Remove the old specialization column if it exists
            if (Schema::hasColumn('teachers', 'specialization')) {
                $table->dropColumn('specialization');
            }
            
            // Add the new subject_id foreign key
            $table->foreignId('subject_id')
                  ->nullable()
                  ->after('school_id')
                  ->constrained()
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropForeign(['subject_id']);
            $table->dropColumn('subject_id');
            $table->string('specialization')->nullable(); // Restore the old column
        });
    }
}; 