<?php

namespace App\Service\Setup;

use Symfony\Component\Console\Output\BufferedOutput;

use Storage;
use Artisan;

class UpdateService
{
    /**
     * Retrieve the previous version of the system.
     *
     * @return string
     */
    public function getOldVersion()
    {
        return Storage::disk('general')->exists('installed')
            ? Storage::disk('general')->get('installed')
            : '0.0.0';
    }

    /**
     * Updates the "installed" file with the new version.
     * 
     * @return void
     */
    public function updateVersionFile()
    {
        Storage::disk('general')->put('installed', config('app.version'));
    }

    /**
     * Checks if the installed version is different from the one in the source code.
     *
     * @return void
     */
    public function needsUpdate()
    {
        return $this->getOldVersion() !== config('app.version');
    }

    /**
     * Update the server by migrating the database and returing Artisan's output.
     *
     * @return void
     */
    public function update()
    {
        $outputLog = new BufferedOutput;

        Artisan::call('migrate', ['--force' => true], $outputLog);
        
        /* To be determined, see InstallService */
        //Artisan::call('route:cache', [], $outputLog);
        //Artisan::call('view:cache', [], $outputLog);

        return $outputLog->fetch();
    }
}
