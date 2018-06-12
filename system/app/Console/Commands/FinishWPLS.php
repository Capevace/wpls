<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use Illuminate\Support\Facades\Hash;

class FinishWPLS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wpls:finish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finishes the WPLS installation.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $username = $this->ask('Enter your desired login username');
        $email    = $this->ask('Enter your support email');
        $password = $this->secret('Enter your desired password');

        $this->call('migrate', ['--force' => true]);

        $user           = new User;
        $user->name     = 'Administrator';
        $user->email    = $email;
        $user->username = $username;
        $user->password = Hash::make($password);
        $user->save();

        $this->call('config:cache');
        $this->call('route:cache');

        $this->comment('');
        $this->comment('WPLS is setup! Head to /login to go to the admin interface!');
    }
}
