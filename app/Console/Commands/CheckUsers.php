<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CheckUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check all users and their roles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all(['id', 'email', 'role', 'fname', 'lname']);
        
        $this->info('Available Users:');
        $this->table(
            ['ID', 'Name', 'Email', 'Role'],
            $users->map(function($user) {
                return [
                    $user->id,
                    $user->fname . ' ' . $user->lname,
                    $user->email,
                    $user->role
                ];
            })->toArray()
        );
        
        return Command::SUCCESS;
    }
}
