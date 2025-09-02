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
        Schema::table('pre_employment_records', function (Blueprint $table) {
            $table->enum('status', ['Pending', 'Approved', 'Declined',])->default('Pending')->after('uploaded_file');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pre_employment_records', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
