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
        Schema::table('medical_test_reference_ranges', function (Blueprint $table) {
            $table->foreignId('medical_test_id')->constrained()->onDelete('cascade');
            $table->string('reference_name'); // e.g., 'Color', 'Protein', 'Albumin'
            $table->string('reference_range'); // e.g., 'Yellowish = Normal', '66-83', '35-52'
            $table->integer('sort_order')->default(0); // For ordering the reference ranges
            
            $table->index(['medical_test_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_test_reference_ranges', function (Blueprint $table) {
            $table->dropForeign(['medical_test_id']);
            $table->dropIndex(['medical_test_id', 'sort_order']);
            $table->dropColumn(['medical_test_id', 'reference_name', 'reference_range', 'sort_order']);
        });
    }
};
