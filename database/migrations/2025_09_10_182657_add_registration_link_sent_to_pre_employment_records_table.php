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
        if (Schema::hasTable('pre_employment_records') && !Schema::hasColumn('pre_employment_records', 'registration_link_sent')) {
            Schema::table('pre_employment_records', function (Blueprint $table) {
                $table->boolean('registration_link_sent')->default(false);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('pre_employment_records') && Schema::hasColumn('pre_employment_records', 'registration_link_sent')) {
            Schema::table('pre_employment_records', function (Blueprint $table) {
                $table->dropColumn('registration_link_sent');
            });
        }
    }
};
