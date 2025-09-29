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
        $users = [
            [
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
            ],
            [
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
            ],
            [
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
            ],
            [
                'fname' => 'Nurse Sarah',
                'lname' => 'Johnson',
                'mname' => 'Elizabeth',
                'email' => 'nurse@rsshealth.com',
                'phone' => '09123456741',
                'birthday' => '1992-07-10',
                'age' => 32,
                'company' => null,
                'role' => 'nurse',
                'password' => Hash::make('password123'),
            ],

            [
                'fname' => 'Robert',
                'lname' => 'Chen',
                'mname' => 'T',
                'email' => 'radtech@rsshealth.com',
                'phone' => '09123456794',
                'birthday' => '1988-09-15',
                'age' => 36,
                'company' => null,
                'role' => 'radtech',
                'password' => Hash::make('password123'),
            ],
            [
                'fname' => 'Maria',
                'lname' => 'Santos',
                'mname' => 'R',
                'email' => 'radiologist@rsshealth.com',
                'phone' => '09123456795',
                'birthday' => '1982-04-20',
                'age' => 42,
                'company' => null,
                'role' => 'radiologist',
                'password' => Hash::make('password123'),
            ],
            [
                'fname' => 'James',
                'lname' => 'Wilson',
                'mname' => 'E',
                'email' => 'ecgtech@rsshealth.com',
                'phone' => '09123456796',
                'birthday' => '1990-11-30',
                'age' => 34,
                'company' => null,
                'role' => 'ecgtech',
                'password' => Hash::make('password123'),
            ],
            [
                'fname' => 'Lisa',
                'lname' => 'Park',
                'mname' => 'M',
                'email' => 'plebo@rsshealth.com',
                'phone' => '09123456797',
                'birthday' => '1993-07-25',
                'age' => 31,
                'company' => null,
                'role' => 'plebo',
                'password' => Hash::make('password123'),
            ],
            [
                'fname' => 'Dr. David',
                'lname' => 'Kumar',
                'mname' => 'P',
                'email' => 'pathologist@rsshealth.com',
                'phone' => '09123456798',
                'birthday' => '1980-02-10',
                'age' => 44,
                'company' => null,
                'role' => 'pathologist',
                'password' => Hash::make('password123'),
            ],

            [
                'fname' => 'patient',
                'lname' => '1',
                'mname' => 'P',
                'email' => 'patient@rsshealth.com',
                'phone' => '09123456719',
                'birthday' => '1980-02-11',
                'age' => 44,
                'company' => null,
                'role' => 'patient',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
