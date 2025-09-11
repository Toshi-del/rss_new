<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class TestUserRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:user-roles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test user roles and hasRole method';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();
        
        $this->info('Testing all users:');
        foreach ($users as $user) {
            $this->line("User ID: {$user->id}");
            $this->line("Email: {$user->email}");
            $this->line("Role: {$user->role}");
            $this->line("Has company role: " . ($user->hasRole('company') ? 'Yes' : 'No'));
            $this->line("Has admin role: " . ($user->hasRole('admin') ? 'Yes' : 'No'));
            $this->line("Has patient role: " . ($user->hasRole('patient') ? 'Yes' : 'No'));
            $this->line("---");
        }
        
        return Command::SUCCESS;
    }
}
