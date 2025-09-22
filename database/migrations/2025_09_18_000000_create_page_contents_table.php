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
        Schema::create('page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('page_name'); // login, about, location, services
            $table->string('section_key'); // hero_title, hero_description, etc.
            $table->string('content_type')->default('text'); // text, textarea, image, url
            $table->text('content_value');
            $table->string('display_name'); // Human readable name for admin
            $table->text('description')->nullable(); // Help text for admin
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Ensure unique combination of page and section
            $table->unique(['page_name', 'section_key']);
            $table->index(['page_name', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_contents');
    }
};
