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
        Schema::table('opd_examinations', function (Blueprint $table) {
            if (Schema::hasColumn('opd_examinations', 'appointment_time')) {
                $table->dropColumn('appointment_time');
            }
            if (Schema::hasColumn('opd_examinations', 'appointment_date')) {
                $table->dropColumn('appointment_date');
            }
            if (Schema::hasColumn('opd_examinations', 'customer_email')) {
                $table->dropColumn('customer_email');
            }
            if (Schema::hasColumn('opd_examinations', 'customer_name')) {
                $table->dropColumn('customer_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('opd_examinations', function (Blueprint $table) {
            if (!Schema::hasColumn('opd_examinations', 'customer_name')) {
                $table->string('customer_name')->nullable()->after('name');
            }
            if (!Schema::hasColumn('opd_examinations', 'customer_email')) {
                $table->string('customer_email')->nullable()->after('customer_name');
            }
            if (!Schema::hasColumn('opd_examinations', 'appointment_date')) {
                $table->date('appointment_date')->nullable()->after('date');
            }
            if (!Schema::hasColumn('opd_examinations', 'appointment_time')) {
                $table->string('appointment_time')->nullable()->after('appointment_date');
            }
        });
    }
};





