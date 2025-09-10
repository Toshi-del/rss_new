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
        // SQLite does not support MODIFY COLUMN or ENUM; skip on SQLite.
        if (DB::connection()->getDriverName() === 'sqlite') {
            return; // no-op for sqlite; 'role' remains a string
        }

        Schema::table('users', function (Blueprint $table) {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('patient', 'company', 'admin', 'doctor', 'nurse', 'radtech', 'radiologist', 'ecgtech', 'plebo', 'pathologist') DEFAULT 'patient'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'mysql') {
            return; // no-op
        }

        Schema::table('users', function (Blueprint $table) {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('patient', 'company', 'admin', 'doctor', 'nurse') DEFAULT 'patient'");
        });
    }
};