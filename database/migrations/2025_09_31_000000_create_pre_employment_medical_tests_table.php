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
        Schema::create('pre_employment_medical_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pre_employment_record_id')->constrained()->onDelete('cascade');
            $table->foreignId('medical_test_id')->constrained()->onDelete('cascade');
            $table->foreignId('medical_test_category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Ensure unique constraint: one test per category per record
            $table->unique(['pre_employment_record_id', 'medical_test_category_id'], 'unique_test_per_category');
            
            // Index for performance with custom short name
            $table->index(['pre_employment_record_id', 'medical_test_id'], 'pe_medical_tests_record_test_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_employment_medical_tests');
    }
};
