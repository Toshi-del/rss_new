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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            
            // Polymorphic relationship for the user receiving the notification
            $table->morphs('notifiable'); // notifiable_type, notifiable_id
            
            // Notification details
            $table->string('type'); // e.g., 'appointment_created', 'checklist_completed', etc.
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable(); // Additional data (IDs, URLs, etc.)
            
            // Priority and status
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            
            // Who/what triggered this notification
            $table->string('triggered_by_type')->nullable(); // User, System, etc.
            $table->unsignedBigInteger('triggered_by_id')->nullable();
            $table->string('triggered_by_name')->nullable(); // For display purposes
            
            // Related record information (polymorphic)
            $table->string('related_type')->nullable(); // Appointment, PreEmploymentRecord, etc.
            $table->unsignedBigInteger('related_id')->nullable();
            
            $table->timestamps();
            
            // Indexes for performance (morphs() already creates notifiable index)
            $table->index(['type', 'is_read']);
            $table->index(['priority', 'created_at']);
            $table->index(['triggered_by_type', 'triggered_by_id']);
            $table->index(['related_type', 'related_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
