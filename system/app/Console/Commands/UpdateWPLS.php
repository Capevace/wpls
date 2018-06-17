<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;
use File;

class UpdateWPLS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wpls:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run this to do some things that WPLS may need after updating.';

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
        $version = config('app.version');
        $this->comment('Updating WPLS to ' . config('app.version') . '...');
        $this->comment('');

        // Do changes for version 3.1.0
        $this->version310();
        
        $this->comment('');
        $this->comment('Successfully updated WPLS!');
    }

    /**
     * Applies changes needed after version 3.1.0
     *
     * @return void
     */
    protected function version310()
    {
        /*
         * MOVE OLD PACKAGES TO NEW STORAGE FOLDER - START
         */
        $newPackagesPath = Storage::disk('packages')->path('');
        $newStoragePath  = realpath(
            $newPackagesPath . '/../'
        );

        // If new storage paths dont exist, create them
        if (!File::exists($newPackagesPath)) {
            if (!File::exists($newStoragePath)) {
                File::makeDirectory($newStoragePath, null, true);
            }

            File::makeDirectory($newPackagesPath, null, true);
        }

        // Move all files to the new folder
        $files = Storage::allFiles('packages');
        if (count($files) > 0) {
            $this->comment('Moving packages from old storage path to new one...');
            $this->comment(Storage::disk('packages')->path(''));

            foreach ($files as $file) {
                $matches;
                preg_match('/packages\/(.*)/', $file, $matches);

                $filename = $matches[1];
                $oldPath = storage_path('app/packages/' . $filename);
                $newPath = Storage::disk('packages')->path($filename);

                File::move($oldPath, $newPath);
            }
        }
        /*
         * MOVE OLD PACKAGES TO NEW STORAGE FOLDER - END
         */
    }
}
