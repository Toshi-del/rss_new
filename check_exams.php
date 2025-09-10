<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "AnnualPhysicalExamination count: " . \App\Models\AnnualPhysicalExamination::count() . PHP_EOL;
echo "PreEmploymentExamination count: " . \App\Models\PreEmploymentExamination::count() . PHP_EOL;

$exam = \App\Models\AnnualPhysicalExamination::first();
if($exam) {
    echo "AnnualPhysicalExamination status: " . $exam->status . PHP_EOL;
    echo "AnnualPhysicalExamination name: " . $exam->name . PHP_EOL;
} else {
    echo "No AnnualPhysicalExamination found" . PHP_EOL;
}

$preExam = \App\Models\PreEmploymentExamination::first();
if($preExam) {
    echo "PreEmploymentExamination status: " . $preExam->status . PHP_EOL;
    echo "PreEmploymentExamination name: " . $preExam->name . PHP_EOL;
} else {
    echo "No PreEmploymentExamination found" . PHP_EOL;
}
