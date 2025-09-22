<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change company field from ENUM to VARCHAR to allow any company name
        DB::statement("ALTER TABLE `users` MODIFY `company` VARCHAR(255) NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to ENUM (note: this may cause data loss if there are values not in the enum)
        DB::statement("ALTER TABLE `users` MODIFY `company` ENUM('Pasig Catholic College', 'AsiaPro', 'PrimeLime') NULL");
    }
};
