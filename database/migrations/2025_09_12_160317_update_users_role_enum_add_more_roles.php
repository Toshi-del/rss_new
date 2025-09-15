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
        // Extend the enum to include all roles used across the app, including OPD
        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('patient','company','admin','doctor','nurse','ecgtech','radtech','radiologist','plebo','pathologist','opd') NOT NULL DEFAULT 'patient'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to the original enum set
        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('patient','company','admin','doctor','nurse') NOT NULL DEFAULT 'patient'");
    }
};
