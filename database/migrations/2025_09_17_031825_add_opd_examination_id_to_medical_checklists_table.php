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
            $table->unsignedBigInteger('opd_examination_id')->nullable()->after('annual_physical_examination_id');
            $table->index('opd_examination_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_checklists', function (Blueprint $table) {
            $table->dropIndex(['opd_examination_id']);
            $table->dropColumn('opd_examination_id');
        });
    }
};
