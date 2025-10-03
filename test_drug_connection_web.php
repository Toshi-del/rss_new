<?php
// Simple web-accessible test for drug test connections

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PreEmploymentExamination;
use App\Models\AnnualPhysicalExamination;
use App\Models\DrugTestResult;

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Drug Test Connection Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .success { color: green; }
        .error { color: red; }
        .info { color: blue; }
        .section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>🧪 Drug Test Connection Test Results</h1>
    
    <div class="section">
        <h2>1. Database Structure Check</h2>
        <?php
        try {
            $columns = DB::select("SHOW COLUMNS FROM drug_test_results");
            $columnNames = array_column($columns, 'Field');
            
            echo "<table>";
            echo "<tr><th>Column Check</th><th>Status</th></tr>";
            
            if (in_array('pre_employment_examination_id', $columnNames)) {
                echo "<tr><td>pre_employment_examination_id</td><td class='success'>✅ EXISTS</td></tr>";
            } else {
                echo "<tr><td>pre_employment_examination_id</td><td class='error'>❌ MISSING</td></tr>";
            }
            
            if (in_array('annual_physical_examination_id', $columnNames)) {
                echo "<tr><td>annual_physical_examination_id</td><td class='success'>✅ EXISTS</td></tr>";
            } else {
                echo "<tr><td>annual_physical_examination_id</td><td class='error'>❌ MISSING</td></tr>";
            }
            
            echo "</table>";
        } catch (Exception $e) {
            echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>

    <div class="section">
        <h2>2. Model Relationships Test</h2>
        <?php
        try {
            // Test relationships exist
            $preEmp = new PreEmploymentExamination();
            $annual = new AnnualPhysicalExamination();
            $drugTest = new DrugTestResult();
            
            echo "<table>";
            echo "<tr><th>Relationship</th><th>Status</th></tr>";
            
            // Test each relationship
            $relationships = [
                'PreEmploymentExamination->drugTestResults()' => method_exists($preEmp, 'drugTestResults'),
                'AnnualPhysicalExamination->drugTestResults()' => method_exists($annual, 'drugTestResults'),
                'DrugTestResult->preEmploymentExamination()' => method_exists($drugTest, 'preEmploymentExamination'),
                'DrugTestResult->annualPhysicalExamination()' => method_exists($drugTest, 'annualPhysicalExamination')
            ];
            
            foreach ($relationships as $name => $exists) {
                $status = $exists ? "<span class='success'>✅ EXISTS</span>" : "<span class='error'>❌ MISSING</span>";
                echo "<tr><td>{$name}</td><td>{$status}</td></tr>";
            }
            
            echo "</table>";
        } catch (Exception $e) {
            echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>

    <div class="section">
        <h2>3. Data Connection Test</h2>
        <?php
        try {
            // Test Pre-Employment connections
            $preEmpExams = PreEmploymentExamination::with('drugTestResults')->take(5)->get();
            echo "<h3>Pre-Employment Examinations with Drug Tests:</h3>";
            
            if ($preEmpExams->count() > 0) {
                echo "<table>";
                echo "<tr><th>Exam ID</th><th>Patient Name</th><th>Drug Test Count</th><th>Latest Result</th></tr>";
                
                foreach ($preEmpExams as $exam) {
                    $drugTestCount = $exam->drugTestResults->count();
                    $latestResult = $exam->drugTestResults->first();
                    $resultInfo = $latestResult ? 
                        "Meth: {$latestResult->methamphetamine_result}, MJ: {$latestResult->marijuana_result}" : 
                        "No results";
                    
                    echo "<tr>";
                    echo "<td>{$exam->id}</td>";
                    echo "<td>{$exam->name}</td>";
                    echo "<td>{$drugTestCount}</td>";
                    echo "<td>{$resultInfo}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p class='info'>ℹ️ No pre-employment examinations found</p>";
            }
            
            // Test Annual Physical connections
            $annualExams = AnnualPhysicalExamination::with('drugTestResults')->take(5)->get();
            echo "<h3>Annual Physical Examinations with Drug Tests:</h3>";
            
            if ($annualExams->count() > 0) {
                echo "<table>";
                echo "<tr><th>Exam ID</th><th>Patient Name</th><th>Drug Test Count</th><th>Latest Result</th></tr>";
                
                foreach ($annualExams as $exam) {
                    $drugTestCount = $exam->drugTestResults->count();
                    $latestResult = $exam->drugTestResults->first();
                    $resultInfo = $latestResult ? 
                        "Meth: {$latestResult->methamphetamine_result}, MJ: {$latestResult->marijuana_result}" : 
                        "No results";
                    
                    echo "<tr>";
                    echo "<td>{$exam->id}</td>";
                    echo "<td>{$exam->name}</td>";
                    echo "<td>{$drugTestCount}</td>";
                    echo "<td>{$resultInfo}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p class='info'>ℹ️ No annual physical examinations found</p>";
            }
            
        } catch (Exception $e) {
            echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>

    <div class="section">
        <h2>4. Recent Drug Test Results</h2>
        <?php
        try {
            $recentDrugTests = DrugTestResult::with(['preEmploymentExamination', 'annualPhysicalExamination'])
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
            
            if ($recentDrugTests->count() > 0) {
                echo "<table>";
                echo "<tr><th>ID</th><th>Patient</th><th>Connected To</th><th>Meth Result</th><th>MJ Result</th><th>Status</th><th>Date</th></tr>";
                
                foreach ($recentDrugTests as $result) {
                    $connectedTo = "None";
                    if ($result->preEmploymentExamination) {
                        $connectedTo = "Pre-Emp Exam #{$result->preEmploymentExamination->id}";
                    } elseif ($result->annualPhysicalExamination) {
                        $connectedTo = "Annual Exam #{$result->annualPhysicalExamination->id}";
                    }
                    
                    echo "<tr>";
                    echo "<td>{$result->id}</td>";
                    echo "<td>{$result->patient_name}</td>";
                    echo "<td>{$connectedTo}</td>";
                    echo "<td>{$result->methamphetamine_result}</td>";
                    echo "<td>{$result->marijuana_result}</td>";
                    echo "<td>{$result->status}</td>";
                    echo "<td>{$result->created_at->format('M d, Y H:i')}</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p class='info'>ℹ️ No drug test results found</p>";
            }
            
        } catch (Exception $e) {
            echo "<p class='error'>❌ Error: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>

    <div class="section">
        <h2>5. Test Summary</h2>
        <?php
        $totalTests = 0;
        $passedTests = 0;
        
        // Count database structure
        try {
            $columns = DB::select("SHOW COLUMNS FROM drug_test_results");
            $columnNames = array_column($columns, 'Field');
            
            $totalTests += 2;
            if (in_array('pre_employment_examination_id', $columnNames)) $passedTests++;
            if (in_array('annual_physical_examination_id', $columnNames)) $passedTests++;
        } catch (Exception $e) {}
        
        // Count relationships
        try {
            $preEmp = new PreEmploymentExamination();
            $annual = new AnnualPhysicalExamination();
            $drugTest = new DrugTestResult();
            
            $totalTests += 4;
            if (method_exists($preEmp, 'drugTestResults')) $passedTests++;
            if (method_exists($annual, 'drugTestResults')) $passedTests++;
            if (method_exists($drugTest, 'preEmploymentExamination')) $passedTests++;
            if (method_exists($drugTest, 'annualPhysicalExamination')) $passedTests++;
        } catch (Exception $e) {}
        
        $percentage = $totalTests > 0 ? round(($passedTests / $totalTests) * 100, 1) : 0;
        
        echo "<div style='padding: 20px; background-color: " . ($percentage >= 80 ? '#d4edda' : '#f8d7da') . "; border-radius: 5px;'>";
        echo "<h3>Overall Test Results: {$passedTests}/{$totalTests} ({$percentage}%)</h3>";
        
        if ($percentage >= 80) {
            echo "<p class='success'>✅ <strong>Drug test connections are working properly!</strong></p>";
            echo "<p>The database structure and model relationships have been successfully implemented.</p>";
        } else {
            echo "<p class='error'>❌ <strong>Some issues detected.</strong></p>";
            echo "<p>Please check the individual test results above for details.</p>";
        }
        echo "</div>";
        ?>
    </div>

    <div class="section">
        <h2>6. Next Steps</h2>
        <ul>
            <li><strong>Create a drug test:</strong> Go to nurse dashboard and create a pre-employment or annual physical examination with drug test requirements</li>
            <li><strong>Check connections:</strong> Refresh this page to see if new drug test results are properly connected</li>
            <li><strong>View in forms:</strong> Edit an examination to see if connected drug test data appears in the forms</li>
        </ul>
    </div>

    <p><em>Generated at: <?= date('Y-m-d H:i:s') ?></em></p>
</body>
</html>
