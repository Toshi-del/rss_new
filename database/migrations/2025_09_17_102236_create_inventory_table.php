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
            $table->string('item_name');
            $table->integer('item_quantity')->default(0);
            $table->enum('item_status', ['active', 'inactive', 'out_of_stock'])->default('active');
            $table->text('description')->nullable();
            $table->decimal('unit_price', 10, 2)->nullable();
            $table->string('category')->nullable();
            $table->string('supplier')->nullable();
            $table->date('expiry_date')->nullable();
            $table->integer('minimum_stock')->default(0);
            $table->timestamps();
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
