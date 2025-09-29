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
        Schema::create('appointment_test_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade');
            $table->foreignId('medical_test_id')->constrained()->onDelete('cascade');
            $table->enum('staff_role', [
                'doctor',
                'nurse', 
                'phlebotomist',
                'pathologist',
                'radiologist',
                'radtech',
                'ecg_tech',
                'med_tech'
            ]);
            $table->foreignId('assigned_to_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->text('special_notes')->nullable();
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->json('results')->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index(['appointment_id', 'status']);
            $table->index(['staff_role', 'status']);
            $table->index(['assigned_to_user_id', 'status']);
            $table->index('assigned_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_test_assignments');
    }
};
