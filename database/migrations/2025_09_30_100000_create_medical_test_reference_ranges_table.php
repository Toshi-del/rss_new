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
        Schema::create('medical_test_reference_ranges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_test_id')->constrained()->onDelete('cascade');
            $table->string('reference_name'); // e.g., 'Color', 'Protein', 'Albumin'
            $table->string('reference_range'); // e.g., 'Yellowish = Normal', '66-83', '35-52'
            $table->integer('sort_order')->default(0); // For ordering the reference ranges
            $table->timestamps();
            
            $table->index(['medical_test_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_test_reference_ranges');
    }
};
