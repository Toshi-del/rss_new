<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First create the table without foreign key constraints
        Schema::create('medical_test_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('medical_test_id');
            $table->text('result')->nullable();
            $table->timestamps();
            
            // Composite primary key
            $table->primary(['user_id', 'medical_test_id']);
        });
        
        // Then add the foreign key constraints if the tables exist
        if (Schema::hasTable('users') && Schema::hasTable('medical_tests')) {
            Schema::table('medical_test_user', function (Blueprint $table) {
                $table->foreign('user_id')
                      ->references('id')
                      ->on('users')
                      ->onDelete('cascade');
                      
                $table->foreign('medical_test_id')
                      ->references('id')
                      ->on('medical_tests')
                      ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_test_user');
    }
};
