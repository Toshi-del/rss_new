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
        Schema::create('drug_test_results', function (Blueprint $table) {
            $table->id();
            
            // Foreign key relationships
            $table->unsignedBigInteger('user_id'); // Patient
            $table->unsignedBigInteger('nurse_id'); // Nurse who conducted the test
            $table->unsignedBigInteger('pre_employment_record_id')->nullable();
            $table->unsignedBigInteger('appointment_id')->nullable(); // For annual physical
            $table->unsignedBigInteger('opd_examination_id')->nullable();
            
            // Patient Information
            $table->string('patient_name');
            $table->text('address');
            $table->integer('age');
            $table->enum('gender', ['Male', 'Female']);
            
            // Examination Details
            $table->datetime('examination_datetime');
            $table->date('admission_date')->nullable();
            $table->date('last_intake_date')->nullable();
            $table->string('test_method')->default('URINE TEST KIT');
            
            // Drug Test Results
            $table->enum('methamphetamine_result', ['Negative', 'Positive']);
            $table->text('methamphetamine_remarks')->nullable();
            $table->enum('marijuana_result', ['Negative', 'Positive']);
            $table->text('marijuana_remarks')->nullable();
            
            // Signatures
            $table->string('test_conducted_by'); // Nurse name
            $table->string('conforme')->nullable(); // Patient signature placeholder
            
            // Status and tracking
            $table->enum('status', ['pending', 'completed', 'sent_to_doctor'])->default('pending');
            $table->timestamp('completed_at')->nullable();
            
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('nurse_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pre_employment_record_id')->references('id')->on('pre_employment_records')->onDelete('cascade');
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
            $table->foreign('opd_examination_id')->references('id')->on('opd_examinations')->onDelete('cascade');
            
            // Indexes for better performance
            $table->index(['user_id', 'status']);
            $table->index(['nurse_id']);
            $table->index(['examination_datetime']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drug_test_results');
    }
};
