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
        Schema::create('opd_examinations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name')->nullable();
            $table->date('date')->nullable();
            $table->string('status')->nullable();
            $table->text('illness_history')->nullable();
            $table->text('accidents_operations')->nullable();
            $table->text('past_medical_history')->nullable();
            $table->text('family_history')->nullable();
            $table->text('personal_habits')->nullable();
            $table->text('physical_exam')->nullable();
            $table->text('physical_findings')->nullable();
            $table->text('lab_findings')->nullable();
            $table->string('ecg')->nullable();
            $table->string('skin_marks')->nullable();
            $table->string('visual')->nullable();
            $table->string('ishihara_test')->nullable();
            $table->string('findings')->nullable();
            $table->text('lab_report')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opd_examinations');
    }
};





