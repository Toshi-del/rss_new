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
        Schema::table('drug_test_results', function (Blueprint $table) {
            // Add foreign key to annual_physical_examinations table
            $table->unsignedBigInteger('annual_physical_examination_id')->nullable()->after('pre_employment_examination_id');
            $table->foreign('annual_physical_examination_id')->references('id')->on('annual_physical_examinations')->onDelete('cascade');
            
            // Add index for better performance
            $table->index(['annual_physical_examination_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drug_test_results', function (Blueprint $table) {
            // Drop foreign key and column
            $table->dropForeign(['annual_physical_examination_id']);
            $table->dropIndex(['annual_physical_examination_id']);
            $table->dropColumn('annual_physical_examination_id');
        });
    }
};
