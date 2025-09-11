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
        if (Schema::hasTable('pre_employment_records') && !Schema::hasColumn('pre_employment_records', 'status')) {
            Schema::table('pre_employment_records', function (Blueprint $table) {
                $table->enum('status', ['Pending', 'Approved', 'Declined',])->default('Pending');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('pre_employment_records') && Schema::hasColumn('pre_employment_records', 'status')) {
            Schema::table('pre_employment_records', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
