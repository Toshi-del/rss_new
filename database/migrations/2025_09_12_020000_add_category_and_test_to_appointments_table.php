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
                if (!Schema::hasColumn('appointments', 'medical_test_categories_id')) {
                    $table->foreignId('medical_test_categories_id')->nullable()->after('time_slot')->constrained('medical_test_categories');
                }
                if (!Schema::hasColumn('appointments', 'medical_test_id')) {
                    $table->foreignId('medical_test_id')->nullable()->after('medical_test_categories_id')->constrained('medical_tests');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('appointments')) {
            Schema::table('appointments', function (Blueprint $table) {
                if (Schema::hasColumn('appointments', 'medical_test_id')) {
                    $table->dropForeign(['medical_test_id']);
                    $table->dropColumn('medical_test_id');
                }
                if (Schema::hasColumn('appointments', 'medical_test_categories_id')) {
                    $table->dropForeign(['medical_test_categories_id']);
                    $table->dropColumn('medical_test_categories_id');
                }
            });
        }
    }
};


