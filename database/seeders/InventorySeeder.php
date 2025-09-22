<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventory;
use Carbon\Carbon;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $inventoryItems = [
            [
                'item_name' => 'Surgical Gloves (Latex)',
                'item_quantity' => 500,
                'item_status' => 'active',
                'description' => 'Sterile latex surgical gloves, size medium. Single-use disposable gloves for medical procedures.',
                'unit_price' => 2.50,
                'category' => 'Medical Supplies',
                'supplier' => 'MedSupply Corp',
                'expiry_date' => Carbon::now()->addMonths(18),
                'minimum_stock' => 100,
            ],
            [
                'item_name' => 'Digital Thermometer',
                'item_quantity' => 25,
                'item_status' => 'active',
                'description' => 'Digital infrared thermometer for non-contact temperature measurement.',
                'unit_price' => 45.00,
                'category' => 'Medical Equipment',
                'supplier' => 'HealthTech Solutions',
                'expiry_date' => null,
                'minimum_stock' => 10,
            ],
            [
                'item_name' => 'Disposable Syringes (5ml)',
                'item_quantity' => 8,
                'item_status' => 'active',
                'description' => '5ml disposable syringes with safety needle lock mechanism.',
                'unit_price' => 1.25,
                'category' => 'Medical Supplies',
                'supplier' => 'SafeMed Supplies',
                'expiry_date' => Carbon::now()->addYear(),
                'minimum_stock' => 50,
            ],
            [
                'item_name' => 'Blood Pressure Monitor',
                'item_quantity' => 15,
                'item_status' => 'active',
                'description' => 'Automatic digital blood pressure monitor with large LCD display.',
                'unit_price' => 120.00,
                'category' => 'Medical Equipment',
                'supplier' => 'CardioMed Inc',
                'expiry_date' => null,
                'minimum_stock' => 5,
            ],
            [
                'item_name' => 'Alcohol Swabs',
                'item_quantity' => 0,
                'item_status' => 'out_of_stock',
                'description' => '70% isopropyl alcohol prep pads for skin disinfection.',
                'unit_price' => 0.15,
                'category' => 'Medical Supplies',
                'supplier' => 'CleanCare Products',
                'expiry_date' => Carbon::now()->addMonths(24),
                'minimum_stock' => 200,
            ],
            [
                'item_name' => 'Stethoscope',
                'item_quantity' => 12,
                'item_status' => 'active',
                'description' => 'Professional dual-head stethoscope with tunable diaphragm.',
                'unit_price' => 85.00,
                'category' => 'Medical Equipment',
                'supplier' => 'Professional Medical',
                'expiry_date' => null,
                'minimum_stock' => 8,
            ],
            [
                'item_name' => 'Gauze Pads (4x4)',
                'item_quantity' => 75,
                'item_status' => 'active',
                'description' => 'Sterile gauze pads for wound dressing and cleaning.',
                'unit_price' => 0.50,
                'category' => 'Medical Supplies',
                'supplier' => 'WoundCare Solutions',
                'expiry_date' => Carbon::now()->addMonths(36),
                'minimum_stock' => 100,
            ],
            [
                'item_name' => 'ECG Machine',
                'item_quantity' => 3,
                'item_status' => 'active',
                'description' => '12-lead ECG machine with digital display and printing capability.',
                'unit_price' => 2500.00,
                'category' => 'Medical Equipment',
                'supplier' => 'CardioTech Systems',
                'expiry_date' => null,
                'minimum_stock' => 2,
            ],
            [
                'item_name' => 'Face Masks (N95)',
                'item_quantity' => 45,
                'item_status' => 'active',
                'description' => 'N95 respirator masks for protection against airborne particles.',
                'unit_price' => 3.75,
                'category' => 'PPE',
                'supplier' => 'SafeGuard Medical',
                'expiry_date' => Carbon::now()->addMonths(60),
                'minimum_stock' => 100,
            ],
            [
                'item_name' => 'X-Ray Film',
                'item_quantity' => 0,
                'item_status' => 'inactive',
                'description' => 'Medical X-ray film for radiographic imaging (being phased out for digital).',
                'unit_price' => 8.50,
                'category' => 'Imaging Supplies',
                'supplier' => 'RadiMed Supplies',
                'expiry_date' => Carbon::now()->addMonths(12),
                'minimum_stock' => 20,
            ],
            [
                'item_name' => 'Pulse Oximeter',
                'item_quantity' => 18,
                'item_status' => 'active',
                'description' => 'Fingertip pulse oximeter for measuring oxygen saturation and pulse rate.',
                'unit_price' => 35.00,
                'category' => 'Medical Equipment',
                'supplier' => 'VitalSigns Tech',
                'expiry_date' => null,
                'minimum_stock' => 10,
            ],
            [
                'item_name' => 'Bandages (Elastic)',
                'item_quantity' => 30,
                'item_status' => 'active',
                'description' => 'Elastic compression bandages for sprains and support.',
                'unit_price' => 4.25,
                'category' => 'Medical Supplies',
                'supplier' => 'FlexCare Products',
                'expiry_date' => null,
                'minimum_stock' => 25,
            ],
        ];

        foreach ($inventoryItems as $item) {
            Inventory::create($item);
        }
    }
}
