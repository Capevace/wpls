<?php

namespace App\Service\Setup;

use Storage;
use Artisan;
use App;

use Symfony\Component\Console\Output\BufferedOutput;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class InstallService
{
    /**
     * Gets the full filepath to the environment file.
     *
     * @return void
     */
    public function envPath()
    {
        $app = app();
        return wpls_path($app->environmentFile());
    }

    /**
     * Checks if the system has been installed already or if it still has to be.
     * 
     * It does so by checking if a file called "installed" exists in the general disk space.
     *
     * @return boolean
     */
    public function installedAlready()
    {
        return Storage::disk('general')->exists('installed');
    }

    /**
     * Create the environment file.
     * 
     * @param array $installFormData The validated data passed by the install form.
     * @return void
     */
    public function createEnv($installFormData)
    {
        // Get the example env
        $envContent = Storage::disk('defaults')->get('example.env');

        // Replace all the placeholders
        $envContent = str_replace('[DB_HOST]', $installFormData['db_host'], $envContent);
        $envContent = str_replace('[DB_PORT]', $installFormData['db_port'], $envContent);
        $envContent = str_replace('[DB_DATABASE]', $installFormData['db_database'], $envContent);
        $envContent = str_replace('[DB_USERNAME]', $installFormData['db_user'], $envContent);
        $envContent = str_replace('[DB_PASSWORD]', $installFormData['db_pass'], $envContent);
        $envContent = str_replace('[APP_KEY]', $this->generateAppKey(), $envContent);
        $envContent = str_replace('[APP_URL]', $installFormData['app_url'], $envContent);
        $envContent = str_replace('[ENVATO_API_KEY]', $installFormData['envato_api_key'], $envContent);
        $envContent = str_replace('[UPDATE_PASSWORD]', $installFormData['update_password'], $envContent);

        // Save the env in project root
        file_put_contents(wpls_path('.env'), $envContent);
    }

    /**
     * Calls upon Artisan to migrate the database and capture its output.
     *
     * @return string The output of the Artisan call.
     */
    public function setupDatabase()
    {
        $outputLog = new BufferedOutput;
        
        Artisan::call('migrate', ['--force' => true], $outputLog);

        /* To be determined if this should be done... is not necessary and complicates things in development and during updaing */
        //Artisan::call('route:cache', [], $outputLog);
        //Artisan::call('view:cache', [], $outputLog);

        return $outputLog->fetch();
    }

    /**
     * Create the initial admin account.
     *
     * @param array $validatedData
     * @return void
     */
    public function createAdminAccount($validatedData)
    {
        $user           = new User;
        $user->name     = $validatedData['admin_name'];
        $user->email    = $validatedData['admin_email'];
        $user->username = $validatedData['admin_username'];
        $user->password = Hash::make($validatedData['admin_password']);
        $user->save();
    }

    /**
     * Finish the installation by placing the "installed" file into storage.
     *
     * @return void
     */
    public function finishInstallation()
    {
        Storage::disk('general')->put('installed', config('app.version'));
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
