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
        Schema::table('medical_checklists', function (Blueprint $table) {
            if (!Schema::hasColumn('medical_checklists', 'opd_test_id')) {
                $table->foreignId('opd_test_id')->nullable()->after('annual_physical_examination_id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('medical_checklists', 'customer_name')) {
                $table->string('customer_name')->nullable()->after('name');
            }
            if (!Schema::hasColumn('medical_checklists', 'customer_email')) {
                $table->string('customer_email')->nullable()->after('customer_name');
            }
            if (!Schema::hasColumn('medical_checklists', 'medical_test')) {
                $table->string('medical_test')->nullable()->after('customer_email');
            }
            if (!Schema::hasColumn('medical_checklists', 'test_results')) {
                $table->text('test_results')->nullable()->after('optional_exam');
            }
            if (!Schema::hasColumn('medical_checklists', 'recommendations')) {
                $table->text('recommendations')->nullable()->after('test_results');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_checklists', function (Blueprint $table) {
            $table->dropForeign(['opd_test_id']);
            $table->dropColumn([
                'opd_test_id',
                'customer_name',
                'customer_email',
                'medical_test',
                'test_results',
                'recommendations'
            ]);
        });
    }
};
