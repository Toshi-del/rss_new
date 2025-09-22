<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\MedicalTestCategory;
use App\Models\MedicalTest;

return new class extends Migration
{
    public function up()
    {
        // Get the Appointment and Blood Chemistry categories
        $appointmentCategory = MedicalTestCategory::where('name', 'Appointment')->first();
        $bloodChemistryCategory = MedicalTestCategory::where('name', 'Blood Chemistry')->first();
        
        if ($appointmentCategory && $bloodChemistryCategory) {
            // Package data
            $packages = [
                ['name' => 'Package A', 'description' => 'ELECTROCARDIOGRAM, FASTING BLOOD SUGAR, TOTAL CHOLESTEROL, BLOOD UREA NITROGEN, BLOOD URIC ACID, SGPT, CBC, URINALYSIS AND FECALYSIS', 'sort_order' => 1, 'price' => 1600.00],
                ['name' => 'Package B', 'description' => 'PACKAGE A PLUS TRIGLYCERIDE, HDL & LDL (GOOD AND BAD CHOLESTEROL)', 'sort_order' => 2, 'price' => 1800.00],
                ['name' => 'Package C', 'description' => 'PACKAGE A B PLUS CREATININE & BLD. TYPING', 'sort_order' => 3, 'price' => 2050.00],
                ['name' => 'Package D', 'description' => 'PACKAGE A B C PLUS SODIUM, POTASSIUM, CALCIUM, CHLORIDE', 'sort_order' => 4, 'price' => 2200.00],
                ['name' => 'Package E', 'description' => 'PACKAGE A B C D PLUS (LIVER FUNCTION TEST) TPAG, SGOT, BILIRUBIN PLUS AMYLASE', 'sort_order' => 5, 'price' => 2800.00],
            ];
            
            // Add packages to Appointment category
            foreach ($packages as $packageData) {
                MedicalTest::updateOrCreate(
                    [
                        'medical_test_category_id' => $appointmentCategory->id,
                        'name' => $packageData['name']
                    ],
                    [
                        'description' => $packageData['description'],
                        'sort_order' => $packageData['sort_order'],
                        'price' => $packageData['price'],
                        'is_active' => true,
                    ]
                );
            }
            
            // Add packages to Blood Chemistry category
            foreach ($packages as $packageData) {
                MedicalTest::updateOrCreate(
                    [
                        'medical_test_category_id' => $bloodChemistryCategory->id,
                        'name' => $packageData['name']
                    ],
                    [
                        'description' => $packageData['description'],
                        'sort_order' => $packageData['sort_order'],
                        'price' => $packageData['price'],
                        'is_active' => true,
                    ]
                );
            }
        }
    }

    public function down()
    {
        // Remove packages from both categories
        $appointmentCategory = MedicalTestCategory::where('name', 'Appointment')->first();
        $bloodChemistryCategory = MedicalTestCategory::where('name', 'Blood Chemistry')->first();
        
        if ($appointmentCategory) {
            MedicalTest::where('medical_test_category_id', $appointmentCategory->id)
                ->where('name', 'like', 'Package%')
                ->delete();
        }
        
        if ($bloodChemistryCategory) {
            MedicalTest::where('medical_test_category_id', $bloodChemistryCategory->id)
                ->where('name', 'like', 'Package%')
                ->delete();
        }
    }
};
