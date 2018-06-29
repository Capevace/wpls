<?php

namespace App\Service;
use Storage;
use Artisan;
// use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Output\BufferedOutput;

class UpdateService
{
    /**
     * Retrieve the previous version of the system.
     *
     * @return string
     */
    public function getOldVersion()
    {
        return Storage::disk('general')->exists('version.txt')
            ? Storage::disk('general')->get('version.txt')
            : '0.0.0';
    }

    /**
     * Set the new version of the system.
     * 
     * @return void
     */
    public function updateVersion()
    {
        Storage::disk('general')->put('version.txt', config('app.version'));
    }

    public function update()
    {
        $outputLog = new BufferedOutput;
        Artisan::call('migrate', ['--force' => true], $outputLog);
        Artisan::call('config:cache', [], $outputLog);
        Artisan::call('route:cache', [], $outputLog);
        Artisan::call('view:cache', [], $outputLog);

        return $outputLog->fetch();
    }
}
