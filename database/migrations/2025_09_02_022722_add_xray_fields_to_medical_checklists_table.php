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
            $table->string('xray_done_by')->nullable()->after('physical_exam_done_by');
            $table->date('xray_date')->nullable()->after('xray_done_by');
            $table->text('xray_notes')->nullable()->after('xray_date');
            $table->unsignedBigInteger('radtech_id')->nullable()->after('xray_notes');
            $table->foreign('radtech_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_checklists', function (Blueprint $table) {
            $table->dropForeign(['radtech_id']);
            $table->dropColumn(['xray_done_by', 'xray_date', 'xray_notes', 'radtech_id']);
        });
    }
};
