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
        Schema::create('medical_checklists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->unsignedBigInteger('pre_employment_record_id')->nullable();
            $table->unsignedBigInteger('annual_physical_examination_id')->nullable();
            $table->string('name')->nullable();
            $table->integer('age')->nullable();
            $table->string('number')->nullable();
            $table->date('date')->nullable();
            // Individual examination columns
            $table->boolean('chest_xray_completed')->default(false);
            $table->string('chest_xray_done_by')->nullable();
            $table->boolean('stool_exam_completed')->default(false);
            $table->string('stool_exam_done_by')->nullable();
            $table->boolean('urinalysis_completed')->default(false);
            $table->string('urinalysis_done_by')->nullable();
            $table->boolean('drug_test_completed')->default(false);
            $table->string('drug_test_done_by')->nullable();
            $table->boolean('blood_extraction_completed')->default(false);
            $table->string('blood_extraction_done_by')->nullable();
            $table->boolean('ecg_completed')->default(false);
            $table->string('ecg_done_by')->nullable();
            $table->boolean('physical_exam_completed')->default(false);
            $table->string('physical_exam_done_by')->nullable();
            $table->string('optional_exam')->nullable();
            $table->string('doctor_signature')->nullable();
            $table->string('examination_type')->nullable(); // 'pre_employment' or 'annual_physical'
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('pre_employment_record_id')->references('id')->on('pre_employment_records')->onDelete('cascade');
            $table->foreign('annual_physical_examination_id')->references('id')->on('annual_physical_examinations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_checklists');
    }
};
