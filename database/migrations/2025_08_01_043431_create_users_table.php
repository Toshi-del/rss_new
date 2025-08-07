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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('lname');
            $table->string('fname');
            $table->string('mname')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->date('birthday');
            $table->integer('age');
            $table->enum('company', ['Pasig Catholic College', 'AsiaPro', 'PrimeLime'])->nullable();
            $table->enum('role', ['patient', 'company', 'admin', 'doctor', 'nurse'])->default('patient');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
