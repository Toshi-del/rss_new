<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class OpdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'opd@rsshealth.com'],
            [
                'fname' => 'OPD',
                'lname' => 'User',
                'mname' => null,
                'phone' => '09123456799',
                'birthday' => '1995-01-01',
                'age' => 30,
                'company' => null,
                'role' => 'opd',
                'password' => Hash::make('password123'),
            ]
        );
    }
}





