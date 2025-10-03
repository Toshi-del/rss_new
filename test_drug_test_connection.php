<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PreEmploymentExamination;
use App\Models\AnnualPhysicalExamination;
use App\Models\DrugTestResult;
use App\Models\PreEmploymentRecord;
use App\Models\Patient;

echo "=== Drug Test Connection Test ===\n\n";

// Test 1: Check if relationships are properly defined
echo "1. Testing Model Relationships:\n";

try {
    // Test PreEmploymentExamination -> DrugTestResult relationship
    $preEmpExam = new PreEmploymentExamination();
    $drugTestRelation = $preEmpExam->drugTestResults();
    echo "✅ PreEmploymentExamination->drugTestResults() relationship exists\n";
    
    // Test AnnualPhysicalExamination -> DrugTestResult relationship
    $annualExam = new AnnualPhysicalExamination();
    $drugTestRelation2 = $annualExam->drugTestResults();
    echo "✅ AnnualPhysicalExamination->drugTestResults() relationship exists\n";
    
    // Test DrugTestResult -> PreEmploymentExamination relationship
    $drugTest = new DrugTestResult();
    $preEmpRelation = $drugTest->preEmploymentExamination();
    echo "✅ DrugTestResult->preEmploymentExamination() relationship exists\n";
    
    // Test DrugTestResult -> AnnualPhysicalExamination relationship
    $annualRelation = $drugTest->annualPhysicalExamination();
    echo "✅ DrugTestResult->annualPhysicalExamination() relationship exists\n";
    
} catch (Exception $e) {
    echo "❌ Relationship Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 2: Check database structure
echo "2. Testing Database Structure:\n";

try {
    // Check if drug_test_results table has the new columns
    $columns = \DB::select("SHOW COLUMNS FROM drug_test_results");
    $columnNames = array_column($columns, 'Field');
    
    if (in_array('pre_employment_examination_id', $columnNames)) {
        echo "✅ pre_employment_examination_id column exists in drug_test_results table\n";
    } else {
        echo "❌ pre_employment_examination_id column missing\n";
    }
    
    if (in_array('annual_physical_examination_id', $columnNames)) {
        echo "✅ annual_physical_examination_id column exists in drug_test_results table\n";
    } else {
        echo "❌ annual_physical_examination_id column missing\n";
    }
    
} catch (Exception $e) {
    echo "❌ Database Structure Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 3: Test data creation and relationships
echo "3. Testing Data Creation and Relationships:\n";

try {
    // Find a pre-employment record to test with
    $preEmpRecord = PreEmploymentRecord::with('medicalTest')->first();
    
    if ($preEmpRecord) {
        echo "✅ Found pre-employment record (ID: {$preEmpRecord->id})\n";
        
        // Check if it has an examination
        $examination = $preEmpRecord->preEmploymentExamination;
        if ($examination) {
            echo "✅ Pre-employment examination exists (ID: {$examination->id})\n";
            
            // Check for connected drug test results
            $drugTestResults = $examination->drugTestResults;
            echo "📊 Connected drug test results count: " . $drugTestResults->count() . "\n";
            
            if ($drugTestResults->count() > 0) {
                $firstResult = $drugTestResults->first();
                echo "✅ Drug test result found (ID: {$firstResult->id})\n";
                echo "   - Methamphetamine: {$firstResult->methamphetamine_result}\n";
                echo "   - Marijuana: {$firstResult->marijuana_result}\n";
                echo "   - Status: {$firstResult->status}\n";
                echo "   - Conducted by: {$firstResult->test_conducted_by}\n";
                
                // Test reverse relationship
                $connectedExam = $firstResult->preEmploymentExamination;
                if ($connectedExam && $connectedExam->id === $examination->id) {
                    echo "✅ Reverse relationship working correctly\n";
                } else {
                    echo "❌ Reverse relationship not working\n";
                }
            } else {
                echo "ℹ️  No drug test results connected yet\n";
            }
        } else {
            echo "ℹ️  No examination found for this record\n";
        }
    } else {
        echo "ℹ️  No pre-employment records found\n";
    }
    
} catch (Exception $e) {
    echo "❌ Data Test Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 4: Test Annual Physical connections
echo "4. Testing Annual Physical Connections:\n";

try {
    $patient = Patient::with(['appointment.medicalTest', 'annualPhysicalExamination'])->first();
    
    if ($patient && $patient->annualPhysicalExamination) {
        $annualExam = $patient->annualPhysicalExamination;
        echo "✅ Found annual physical examination (ID: {$annualExam->id})\n";
        
        $drugTestResults = $annualExam->drugTestResults;
        echo "📊 Connected drug test results count: " . $drugTestResults->count() . "\n";
        
        if ($drugTestResults->count() > 0) {
            $firstResult = $drugTestResults->first();
            echo "✅ Annual physical drug test result found (ID: {$firstResult->id})\n";
            echo "   - Connected to examination ID: {$firstResult->annual_physical_examination_id}\n";
        }
    } else {
        echo "ℹ️  No annual physical examinations found\n";
    }
    
} catch (Exception $e) {
    echo "❌ Annual Physical Test Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 5: Test fillable fields
echo "5. Testing Model Fillable Fields:\n";

try {
    $drugTest = new DrugTestResult();
    $fillable = $drugTest->getFillable();
    
    if (in_array('pre_employment_examination_id', $fillable)) {
        echo "✅ pre_employment_examination_id is fillable\n";
    } else {
        echo "❌ pre_employment_examination_id not in fillable array\n";
    }
    
    if (in_array('annual_physical_examination_id', $fillable)) {
        echo "✅ annual_physical_examination_id is fillable\n";
    } else {
        echo "❌ annual_physical_examination_id not in fillable array\n";
    }
    
} catch (Exception $e) {
    echo "❌ Fillable Test Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 6: Test foreign key constraints
echo "6. Testing Foreign Key Constraints:\n";

try {
    $foreignKeys = \DB::select("
        SELECT 
            CONSTRAINT_NAME,
            COLUMN_NAME,
            REFERENCED_TABLE_NAME,
            REFERENCED_COLUMN_NAME
        FROM information_schema.KEY_COLUMN_USAGE 
        WHERE TABLE_NAME = 'drug_test_results' 
        AND REFERENCED_TABLE_NAME IS NOT NULL
        AND TABLE_SCHEMA = DATABASE()
    ");
    
    foreach ($foreignKeys as $fk) {
        if ($fk->COLUMN_NAME === 'pre_employment_examination_id') {
            echo "✅ Foreign key constraint exists: {$fk->COLUMN_NAME} -> {$fk->REFERENCED_TABLE_NAME}.{$fk->REFERENCED_COLUMN_NAME}\n";
        }
        if ($fk->COLUMN_NAME === 'annual_physical_examination_id') {
            echo "✅ Foreign key constraint exists: {$fk->COLUMN_NAME} -> {$fk->REFERENCED_TABLE_NAME}.{$fk->REFERENCED_COLUMN_NAME}\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Foreign Key Test Error: " . $e->getMessage() . "\n";
}

echo "\n=== Test Complete ===\n";
echo "If you see ✅ marks, the connections are working properly!\n";
echo "If you see ❌ marks, there may be issues that need fixing.\n";
echo "ℹ️  marks indicate informational messages.\n";
