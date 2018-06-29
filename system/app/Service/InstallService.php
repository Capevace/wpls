<?php

namespace App\Service;

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
        return $app->environmentPath().'/'.$app->environmentFile();
    }

    /**
     * Checks if the system has been installed already or if it still has to be.
     *
     * @return boolean
     */
    public function installedAlready()
    {
        return file_exists($this->envPath());
    }
}
