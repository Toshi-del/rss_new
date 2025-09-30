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
        // Add address column to patients table
        Schema::table('patients', function (Blueprint $table) {
            $table->text('address')->nullable()->after('phone');
        });

        // Add address column to pre_employment_records table
        Schema::table('pre_employment_records', function (Blueprint $table) {
            $table->text('address')->nullable()->after('phone_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove address column from patients table
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn('address');
        });

        // Remove address column from pre_employment_records table
        Schema::table('pre_employment_records', function (Blueprint $table) {
            $table->dropColumn('address');
        });
    }
};
