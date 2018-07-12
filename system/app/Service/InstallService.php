<?php

namespace App\Service;
use Storage;
use Artisan;
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
        return $this->rootEnvPath() . '/' . $app->environmentFile();
    }

    public function rootEnvPath()
    {
        return realpath(base_path() . '/..');
    }

    /**
     * Checks if the system has been installed already or if it still has to be.
     *
     * @return boolean
     */
    public function installedAlready()
    {
        return Storage::disk('local')->exists('installed');
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
        $path = $this->rootEnvPath();
        file_put_contents($path.'/.env', $envContent);
    }

    public function setupDatabase()
    {
        $outputLog = new BufferedOutput;
        Artisan::call('migrate', ['--force' => true], $outputLog);
        //Artisan::call('route:cache', [], $outputLog);
        //Artisan::call('view:cache', [], $outputLog);

        return $outputLog->fetch();
    }

    public function createAdminAccount($validatedData)
    {
        $user           = new User;
        $user->name     = $validatedData['admin_name'];
        $user->email    = $validatedData['admin_email'];
        $user->username = $validatedData['admin_username'];
        $user->password = Hash::make($validatedData['admin_password']);
        $user->save();
    }

    public function finishInstallation()
    {
        Storage::disk('local')->put('installed', 'installed');
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
