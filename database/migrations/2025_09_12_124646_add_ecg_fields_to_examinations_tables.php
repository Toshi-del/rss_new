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
        // Add ECG fields to pre_employment_examinations table
        Schema::table('pre_employment_examinations', function (Blueprint $table) {
            $table->date('ecg_date')->nullable()->after('ecg');
            $table->string('ecg_technician')->nullable()->after('ecg_date');
            $table->unsignedBigInteger('created_by')->nullable()->after('ecg_technician');
        });

        // Add ECG fields to annual_physical_examinations table
        Schema::table('annual_physical_examinations', function (Blueprint $table) {
            $table->date('ecg_date')->nullable()->after('ecg');
            $table->string('ecg_technician')->nullable()->after('ecg_date');
            $table->unsignedBigInteger('created_by')->nullable()->after('ecg_technician');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pre_employment_examinations', function (Blueprint $table) {
            $table->dropColumn(['ecg_date', 'ecg_technician', 'created_by']);
        });

        Schema::table('annual_physical_examinations', function (Blueprint $table) {
            $table->dropColumn(['ecg_date', 'ecg_technician', 'created_by']);
        });
    }
};