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
        Schema::table('pre_employment_records', function (Blueprint $table) {
            // Remove the old single test columns
            $table->dropForeign(['medical_test_categories_id']);
            $table->dropColumn(['medical_test_categories_id', 'medical_test_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pre_employment_records', function (Blueprint $table) {
            // Restore the old columns if needed
            $table->foreignId('medical_test_categories_id')->nullable()->constrained('medical_test_categories');
            $table->unsignedBigInteger('medical_test_id')->nullable();
        });
    }
};
