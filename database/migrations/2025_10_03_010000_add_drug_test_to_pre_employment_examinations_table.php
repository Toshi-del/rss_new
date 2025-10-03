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
        Schema::table('pre_employment_examinations', function (Blueprint $table) {
            $table->text('drug_test')->nullable()->after('lab_report'); // JSON for drug test results
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pre_employment_examinations', function (Blueprint $table) {
            $table->dropColumn('drug_test');
        });
    }
};
