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
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_id')->constrained('inventory')->onDelete('cascade');
            $table->string('type'); // 'restock', 'usage', 'adjustment', 'expired', 'damaged'
            $table->integer('quantity'); // positive for additions, negative for reductions
            $table->integer('quantity_before'); // quantity before this transaction
            $table->integer('quantity_after'); // quantity after this transaction
            $table->text('notes')->nullable();
            $table->string('reference_number')->nullable(); // PO number, request number, etc.
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            // Indexes
            $table->index(['inventory_id', 'type']);
            $table->index(['inventory_id', 'created_at']);
            $table->index('type');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
