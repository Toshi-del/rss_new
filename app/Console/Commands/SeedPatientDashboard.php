<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\PatientDashboardSeeder;

class SeedPatientDashboard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:patient-dashboard';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with patient dashboard test data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Seeding patient dashboard data...');
        
        $seeder = new PatientDashboardSeeder();
        $seeder->run();
        
        $this->info('Patient dashboard data seeded successfully!');
        $this->info('');
        $this->info('Test patient accounts:');
        $this->info('- patient@rsshealth.com / password');
        $this->info('- john.smith@rsshealth.com / password');
        $this->info('- maria.garcia@rsshealth.com / password');
        $this->info('- carlos.rodriguez@rsshealth.com / password');
        $this->info('- ana.martinez@rsshealth.com / password');
    }
}
