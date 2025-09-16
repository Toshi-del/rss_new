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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id();
            
            // Basic item information
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('sku')->unique();
            $table->string('category');
            $table->string('unit');
            
            // Quantity management
            $table->integer('current_quantity')->default(0);
            $table->integer('minimum_quantity')->default(0);
            $table->integer('maximum_quantity')->nullable();
            
            // Cost management
            $table->decimal('unit_cost', 10, 2)->default(0.00);
            $table->decimal('total_cost', 12, 2)->default(0.00);
            
            // Supplier and location
            $table->string('supplier')->nullable();
            $table->string('location')->nullable();
            
            // Expiry and status
            $table->date('expiry_date')->nullable();
            $table->string('status')->default('active');
            
            // Additional information
            $table->text('notes')->nullable();
            
            // Audit trail
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            
            // Timestamps
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for better performance
            $table->index('category');
            $table->index('status');
            $table->index('sku');
            $table->index(['current_quantity', 'minimum_quantity']);
            $table->index('expiry_date');
            $table->index('created_at');
            
            // Foreign key constraints
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};
