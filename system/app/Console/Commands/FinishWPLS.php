<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FinishWPLS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wpls:finish {--pretend}';

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
        // Pretend would mean that the database will not be migrated
        $shouldPretend = $this->option('pretend');

        // Collect the user account details
        $username = $this->ask('Enter your desired login username');
        $email    = $this->ask('Enter your support email');
        $password = $this->secret('Enter your desired password');

        // Migrate database, force flag is necessary because the APP_ENV is production
        $this->call('migrate', ['--force' => true, '--pretend' => $shouldPretend]);

        $user           = new User;
        $user->name     = 'Administrator';
        $user->email    = $email;
        $user->username = $username;
        $user->password = Hash::make($password);
        $user->save();

        // Cache config, route and views
        $this->call('config:cache');
        $this->call('route:cache');
        $this->call('view:cache');

        $this->comment('');
        $this->comment('WPLS is setup! Head to /login to go to the admin interface!');
    }
}
