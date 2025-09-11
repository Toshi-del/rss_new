<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('appointments')) {
            Schema::table('appointments', function (Blueprint $table) {
                if (Schema::hasColumn('appointments', 'appointment_type')) {
                    $table->dropColumn('appointment_type');
                }
                if (Schema::hasColumn('appointments', 'blood_chemistry')) {
                    $table->dropColumn('blood_chemistry');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('appointments')) {
            Schema::table('appointments', function (Blueprint $table) {
                if (!Schema::hasColumn('appointments', 'appointment_type')) {
                    $table->string('appointment_type')->nullable();
                }
                if (!Schema::hasColumn('appointments', 'blood_chemistry')) {
                    $table->json('blood_chemistry')->nullable();
                }
            });
        }
    }
};


