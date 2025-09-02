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
        Schema::table('users', function (Blueprint $table) {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('patient', 'company', 'admin', 'doctor', 'nurse', 'radtech', 'radiologist', 'ecgtech', 'plebo', 'pathologist') DEFAULT 'patient'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('patient', 'company', 'admin', 'doctor', 'nurse') DEFAULT 'patient'");
        });
    }
};