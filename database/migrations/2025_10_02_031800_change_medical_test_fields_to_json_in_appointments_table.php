<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('appointments')) {
            // Get existing foreign key names
            $foreignKeys = $this->getForeignKeys('appointments');
            
            Schema::table('appointments', function (Blueprint $table) use ($foreignKeys) {
                // Drop foreign key constraints if they exist
                foreach ($foreignKeys as $fk) {
                    if (in_array($fk['column'], ['medical_test_id', 'medical_test_categories_id'])) {
                        $table->dropForeign($fk['name']);
                    }
                }
            });
            
            // Change column types to JSON to support multiple test selections
            Schema::table('appointments', function (Blueprint $table) {
                if (Schema::hasColumn('appointments', 'medical_test_categories_id')) {
                    $table->json('medical_test_categories_id')->nullable()->change();
                }
                if (Schema::hasColumn('appointments', 'medical_test_id')) {
                    $table->json('medical_test_id')->nullable()->change();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('appointments')) {
            // Change back to integer columns
            Schema::table('appointments', function (Blueprint $table) {
                if (Schema::hasColumn('appointments', 'medical_test_categories_id')) {
                    $table->unsignedBigInteger('medical_test_categories_id')->nullable()->change();
                }
                if (Schema::hasColumn('appointments', 'medical_test_id')) {
                    $table->unsignedBigInteger('medical_test_id')->nullable()->change();
                }
            });
            
            // Re-add foreign key constraints
            Schema::table('appointments', function (Blueprint $table) {
                if (Schema::hasColumn('appointments', 'medical_test_categories_id')) {
                    $table->foreign('medical_test_categories_id')->references('id')->on('medical_test_categories');
                }
                if (Schema::hasColumn('appointments', 'medical_test_id')) {
                    $table->foreign('medical_test_id')->references('id')->on('medical_tests');
                }
            });
        }
    }
    
    private function getForeignKeys($table)
    {
        $foreignKeys = [];
        $results = DB::select("
            SELECT 
                CONSTRAINT_NAME as constraint_name,
                COLUMN_NAME as column_name
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = ? 
            AND CONSTRAINT_NAME != 'PRIMARY'
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ", [$table]);
        
        foreach ($results as $result) {
            $foreignKeys[] = [
                'name' => $result->constraint_name,
                'column' => $result->column_name
            ];
        }
        
        return $foreignKeys;
    }
};
