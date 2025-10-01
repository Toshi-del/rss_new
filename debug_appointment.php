<?php
// Debug script to test appointment validation logic
require_once 'vendor/autoload.php';

// Simulate the validation logic
$request_categories = '["3","4"]'; // Example JSON from frontend
$request_tests = '["5","6"]'; // Example JSON from frontend

echo "=== DEBUGGING APPOINTMENT VALIDATION ===\n";
echo "Raw categories from request: " . $request_categories . "\n";
echo "Raw tests from request: " . $request_tests . "\n";

// Decode JSON arrays from frontend
$categoryIds = array_map('intval', json_decode($request_categories, true) ?: []);
$testIds = array_map('intval', json_decode($request_tests, true) ?: []);

echo "Decoded category IDs: " . print_r($categoryIds, true) . "\n";
echo "Decoded test IDs: " . print_r($testIds, true) . "\n";

// Check if arrays are empty
if (empty($categoryIds) || empty($testIds)) {
    echo "ERROR: Empty arrays detected\n";
    exit;
}

// Check if arrays have same length
if (count($categoryIds) !== count($testIds)) {
    echo "ERROR: Array length mismatch\n";
    echo "Category count: " . count($categoryIds) . "\n";
    echo "Test count: " . count($testIds) . "\n";
    exit;
}

echo "Arrays look good so far...\n";
echo "Next step would be database validation\n";
?>
