<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Inventory;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inventoryItems = [
            // Diagnostic Equipment
            [
                'item_name' => 'Digital X-Ray Machine',
                'item_quantity' => 2,
                'description' => 'High-resolution digital X-ray machine for chest and bone imaging',
            ],
            [
                'item_name' => 'ECG Machine',
                'item_quantity' => 3,
                'description' => '12-lead electrocardiogram machine for cardiac monitoring',
            ],
            [
                'item_name' => 'Ultrasound Machine',
                'item_quantity' => 1,
                'description' => 'Portable ultrasound machine for abdominal and pelvic imaging',
            ],
            [
                'item_name' => 'Blood Pressure Monitor',
                'item_quantity' => 15,
                'description' => 'Digital sphygmomanometer for accurate blood pressure measurement',
            ],
            [
                'item_name' => 'Stethoscope',
                'item_quantity' => 20,
                'description' => 'Professional grade stethoscope for cardiac and pulmonary examination',
            ],
            [
                'item_name' => 'Ophthalmoscope',
                'item_quantity' => 5,
                'description' => 'Direct ophthalmoscope for eye examination',
            ],
            [
                'item_name' => 'Otoscope',
                'item_quantity' => 8,
                'description' => 'Diagnostic otoscope for ear examination',
            ],
            [
                'item_name' => 'Thermometer (Digital)',
                'item_quantity' => 25,
                'description' => 'Digital thermometer for body temperature measurement',
            ],
            [
                'item_name' => 'Pulse Oximeter',
                'item_quantity' => 12,
                'description' => 'Fingertip pulse oximeter for oxygen saturation monitoring',
            ],
            [
                'item_name' => 'Weighing Scale',
                'item_quantity' => 6,
                'description' => 'Digital weighing scale for patient weight measurement',
            ],
            [
                'item_name' => 'Height Measuring Rod',
                'item_quantity' => 4,
                'description' => 'Portable height measuring rod for anthropometric assessment',
            ],
            [
                'item_name' => 'Snellen Chart',
                'item_quantity' => 3,
                'description' => 'Visual acuity testing chart for eye examination',
            ],

            // Laboratory Equipment
            [
                'item_name' => 'Microscope (Binocular)',
                'item_quantity' => 4,
                'description' => 'High-magnification binocular microscope for laboratory analysis',
            ],
            [
                'item_name' => 'Centrifuge Machine',
                'item_quantity' => 2,
                'description' => 'Laboratory centrifuge for blood and urine sample processing',
            ],
            [
                'item_name' => 'Chemistry Analyzer',
                'item_quantity' => 1,
                'description' => 'Automated chemistry analyzer for blood chemistry tests',
            ],
            [
                'item_name' => 'Hematology Analyzer',
                'item_quantity' => 1,
                'description' => 'Complete blood count analyzer for hematological testing',
            ],
            [
                'item_name' => 'Urine Analyzer',
                'item_quantity' => 1,
                'description' => 'Automated urine chemistry analyzer',
            ],
            [
                'item_name' => 'Incubator',
                'item_quantity' => 2,
                'description' => 'Laboratory incubator for bacterial culture growth',
            ],
            [
                'item_name' => 'Autoclave',
                'item_quantity' => 1,
                'description' => 'Steam sterilizer for laboratory equipment sterilization',
            ],
            [
                'item_name' => 'Refrigerator (Lab Grade)',
                'item_quantity' => 2,
                'description' => 'Laboratory-grade refrigerator for reagent and sample storage',
            ],

            // Laboratory Supplies
            [
                'item_name' => 'Blood Collection Tubes (EDTA)',
                'item_quantity' => 500,
                'description' => 'Purple-top tubes with EDTA anticoagulant for hematology tests',
            ],
            [
                'item_name' => 'Blood Collection Tubes (Serum)',
                'item_quantity' => 300,
                'description' => 'Red-top tubes for serum collection and chemistry tests',
            ],
            [
                'item_name' => 'Urine Collection Containers',
                'item_quantity' => 200,
                'description' => 'Sterile containers for urine sample collection',
            ],
            [
                'item_name' => 'Microscope Slides',
                'item_quantity' => 1000,
                'description' => 'Glass microscope slides for specimen examination',
            ],
            [
                'item_name' => 'Cover Slips',
                'item_quantity' => 2000,
                'description' => 'Glass cover slips for microscope slide preparation',
            ],
            [
                'item_name' => 'Disposable Syringes (5ml)',
                'item_quantity' => 100,
                'description' => 'Sterile disposable syringes for blood collection',
            ],
            [
                'item_name' => 'Needles (21G)',
                'item_quantity' => 200,
                'description' => '21-gauge needles for blood collection',
            ],
            [
                'item_name' => 'Alcohol Swabs',
                'item_quantity' => 500,
                'description' => 'Alcohol prep pads for skin disinfection',
            ],
            [
                'item_name' => 'Cotton Balls',
                'item_quantity' => 300,
                'description' => 'Sterile cotton balls for wound care and sample collection',
            ],
            [
                'item_name' => 'Disposable Gloves (Nitrile)',
                'item_quantity' => 1000,
                'description' => 'Powder-free nitrile examination gloves',
            ],
            [
                'item_name' => 'Face Masks (Surgical)',
                'item_quantity' => 200,
                'description' => 'Disposable surgical face masks for infection control',
            ],

            // Reagents and Chemicals
            [
                'item_name' => 'Glucose Reagent Kit',
                'item_quantity' => 10,
                'description' => 'Reagent kit for blood glucose testing',
            ],
            [
                'item_name' => 'Cholesterol Test Kit',
                'item_quantity' => 8,
                'description' => 'Reagent kit for cholesterol level testing',
            ],
            [
                'item_name' => 'Uric Acid Test Kit',
                'item_quantity' => 6,
                'description' => 'Reagent kit for uric acid level testing',
            ],
            [
                'item_name' => 'Creatinine Test Kit',
                'item_quantity' => 7,
                'description' => 'Reagent kit for creatinine level testing',
            ],
            [
                'item_name' => 'Liver Function Test Kit',
                'item_quantity' => 5,
                'description' => 'Complete reagent kit for liver function testing',
            ],
            [
                'item_name' => 'Urinalysis Reagent Strips',
                'item_quantity' => 50,
                'description' => 'Multi-parameter urine test strips',
            ],
            [
                'item_name' => 'Blood Typing Kit',
                'item_quantity' => 12,
                'description' => 'ABO and Rh blood typing reagent kit',
            ],
            [
                'item_name' => 'Pregnancy Test Kit',
                'item_quantity' => 25,
                'description' => 'HCG pregnancy test kit for urine samples',
            ],

            // Consumables and Supplies
            [
                'item_name' => 'ECG Electrodes',
                'item_quantity' => 200,
                'description' => 'Disposable ECG electrodes for cardiac monitoring',
            ],
            [
                'item_name' => 'X-Ray Films (14x17)',
                'item_quantity' => 0,
                'description' => 'X-ray films for chest radiography - OUT OF STOCK',
            ],
            [
                'item_name' => 'Ultrasound Gel',
                'item_quantity' => 15,
                'description' => 'Conductive gel for ultrasound examinations',
            ],
            [
                'item_name' => 'Disinfectant Solution',
                'item_quantity' => 20,
                'description' => 'Hospital-grade disinfectant for equipment cleaning',
            ],
            [
                'item_name' => 'Paper Towels',
                'item_quantity' => 50,
                'description' => 'Disposable paper towels for cleaning and drying',
            ],
            [
                'item_name' => 'Specimen Labels',
                'item_quantity' => 1000,
                'description' => 'Adhesive labels for specimen identification',
            ],
            [
                'item_name' => 'Biohazard Bags',
                'item_quantity' => 100,
                'description' => 'Red biohazard waste disposal bags',
            ],
            [
                'item_name' => 'Sharps Container',
                'item_quantity' => 8,
                'description' => 'Puncture-resistant containers for needle disposal',
            ],

            // Emergency and First Aid
            [
                'item_name' => 'Emergency Oxygen Tank',
                'item_quantity' => 3,
                'description' => 'Portable oxygen tank for emergency situations',
            ],
            [
                'item_name' => 'Defibrillator (AED)',
                'item_quantity' => 1,
                'description' => 'Automated external defibrillator for cardiac emergencies',
            ],
            [
                'item_name' => 'First Aid Kit',
                'item_quantity' => 5,
                'description' => 'Complete first aid kit for emergency treatment',
            ],
            [
                'item_name' => 'Emergency Medications Kit',
                'item_quantity' => 2,
                'description' => 'Essential emergency medications for critical situations',
            ],

            // Out of Stock Items (for demonstration)
            [
                'item_name' => 'CT Contrast Dye',
                'item_quantity' => 0,
                'description' => 'Iodinated contrast agent for CT imaging - NEEDS RESTOCKING',
            ],
            [
                'item_name' => 'Hepatitis B Test Kit',
                'item_quantity' => 0,
                'description' => 'Hepatitis B surface antigen test kit - OUT OF STOCK',
            ],
        ];

        foreach ($inventoryItems as $item) {
            Inventory::create($item);
        }
    }
}
