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
        Schema::create('equipment_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_request_id')->constrained('equipment_requests')->onDelete('cascade');
            $table->foreignId('inventory_id')->constrained('inventory')->onDelete('cascade');
            $table->integer('quantity_requested');
            $table->integer('quantity_approved')->default(0);
            $table->integer('quantity_fulfilled')->default(0);
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'approved', 'partial', 'fulfilled', 'rejected'])->default('pending');
            $table->timestamps();

            // Indexes
            $table->index(['equipment_request_id', 'status']);
            $table->index('inventory_id');
            
            // Unique constraint to prevent duplicate items in same request
            $table->unique(['equipment_request_id', 'inventory_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_request_items');
    }
};
