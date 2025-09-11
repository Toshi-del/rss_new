<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medical_checklists', function (Blueprint $table) {
            if (!Schema::hasColumn('medical_checklists', 'xray_image_path')) {
                $table->string('xray_image_path')->nullable()->after('number');
            }
        });
    }

    public function down(): void
    {
        Schema::table('medical_checklists', function (Blueprint $table) {
            if (Schema::hasColumn('medical_checklists', 'xray_image_path')) {
                $table->dropColumn('xray_image_path');
            }
        });
    }
};


