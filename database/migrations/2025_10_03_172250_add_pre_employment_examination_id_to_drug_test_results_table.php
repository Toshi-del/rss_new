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
            // Add foreign key to pre_employment_examinations table
            $table->unsignedBigInteger('pre_employment_examination_id')->nullable()->after('pre_employment_record_id');
            $table->foreign('pre_employment_examination_id')->references('id')->on('pre_employment_examinations')->onDelete('cascade');
            
            // Add index for better performance
            $table->index(['pre_employment_examination_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drug_test_results', function (Blueprint $table) {
            // Drop foreign key and column
            $table->dropForeign(['pre_employment_examination_id']);
            $table->dropIndex(['pre_employment_examination_id']);
            $table->dropColumn('pre_employment_examination_id');
        });
    }
};
