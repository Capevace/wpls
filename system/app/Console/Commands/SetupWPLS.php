<?php

namespace App\Console\Commands;

use Illuminate\Encryption\Encrypter;
use Illuminate\Console\Command;
use Storage;

class SetupWPLS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wpls:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup WPLS.';

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
        $this->comment('Thanks for buying WPLS!');
        $this->comment('We will now setup the system for you.');
        $this->comment('You will need your MySQL credentials and an Envato API key.');

        // Collect env data
        $dbHost = $this->anticipate('Enter MySQL Host (most likely 127.0.0.1)', ['127.0.0.1']);
        $dbPort = $this->anticipate('Enter MySQL Port (most likely 3306)', ['3306']);
        $dbName = $this->ask('Enter MySQL Database Name');
        $dbUser = $this->ask('Enter MySQL Username');
        $dbPass = $this->secret('Enter MySQL Password');
        $url    = $this->ask('Enter the URL WPLS will be hosted on (e.g. http://wpls.com/path/to/wpls/');
        $envatoApiKey = $this->secret('Enter an Envato API Key (see documentation for help)');

        // Get the example env
        $envContent = Storage::disk('defaults')->get('example.env');

        // Replace all the placeholders
        $envContent = str_replace('[DB_HOST]', $dbHost, $envContent);
        $envContent = str_replace('[DB_PORT]', $dbPort, $envContent);
        $envContent = str_replace('[DB_DATABASE]', $dbName, $envContent);
        $envContent = str_replace('[DB_USERNAME]', $dbUser, $envContent);
        $envContent = str_replace('[DB_PASSWORD]', $dbPass, $envContent);
        $envContent = str_replace('[APP_KEY]', $this->generateAppKey(), $envContent);
        $envContent = str_replace('[APP_URL]', $url, $envContent);
        $envContent = str_replace('[ENVATO_API_KEY]', $envatoApiKey, $envContent);

        // Save the env in project root
        $path = realpath(base_path().'/..');
        file_put_contents($path.'/.env', $envContent);

        $this->info('Successfully generated .env file!');
        $this->info('');
        $this->comment('To finish your setup now call');
        $this->line('/path/to/php artisan wpls:finish');
    }

    /**
     * Generates an AES key to be used in the env file.
     *
     * @return string
     */
    protected function generateAppKey()
    {
        return 'base64:'.base64_encode(
            Encrypter::generateKey('AES-256-CBC')
        );
    }
}
