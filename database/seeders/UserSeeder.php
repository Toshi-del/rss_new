<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'fname' => 'Admin',
            'lname' => 'User',
            'mname' => null,
            'email' => 'admin@rsshealth.com',
            'phone' => '09123456789',
            'birthday' => '1990-01-01',
            'age' => 34,
            'company' => null,
            'role' => 'admin',
            'password' => Hash::make('password123'),
        ]);

        // Company User
        User::create([
            'fname' => 'Company',
            'lname' => 'Manager',
            'mname' => null,
            'email' => 'company@rsshealth.com',
            'phone' => '09123456790',
            'birthday' => '1985-05-15',
            'age' => 39,
            'company' => 'Pasig Catholic College',
            'role' => 'company',
            'password' => Hash::make('password123'),
        ]);

        // Doctor User
        User::create([
            'fname' => 'Dr. John',
            'lname' => 'Smith',
            'mname' => 'Michael',
            'email' => 'doctor@rsshealth.com',
            'phone' => '09123456791',
            'birthday' => '1980-03-20',
            'age' => 44,
            'company' => null,
            'role' => 'doctor',
            'password' => Hash::make('password123'),
        ]);

        // Nurse User
        User::create([
            'fname' => 'Nurse Sarah',
            'lname' => 'Johnson',
            'mname' => 'Elizabeth',
            'email' => 'nurse@rsshealth.com',
            'phone' => '09123456792',
            'birthday' => '1992-07-10',
            'age' => 32,
            'company' => null,
            'role' => 'nurse',
            'password' => Hash::make('password123'),
        ]);

        // Patient User
        User::create([
            'fname' => 'Patient',
            'lname' => 'Doe',
            'mname' => 'Jane',
            'email' => 'patient@rsshealth.com',
            'phone' => '09123456793',
            'birthday' => '1995-12-25',
            'age' => 29,
            'company' => 'AsiaPro',
            'role' => 'patient',
            'password' => Hash::make('password123'),
        ]);
    }
}
