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
        Schema::create('medical_test_routings', function (Blueprint $table) {
            $table->id();
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
            $table->integer('priority')->default(1); // Lower number = higher priority
            $table->boolean('requires_special_note')->default(false);
            $table->text('special_note_template')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexes for better performance
            $table->index(['medical_test_id', 'is_active']);
            $table->index(['staff_role', 'is_active']);
            $table->index('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_test_routings');
    }
};
