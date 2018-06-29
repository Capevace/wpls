<?php

namespace App\Providers;

use App\Service\LicenseVerification;
use App\Service\LicenseStateService;
use App\Service\PackageParser;
use App\Service\ActivationLog;
use App\Service\InstallService;
use App\Auth\ActivationGuard;

use \Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */
    public $singletons = [
        LicenseVerification::class => LicenseVerification::class,
        LicenseStateService::class => LicenseStateService::class,
        PackageParser::class => PackageParser::class,
        ActivationLog::class => ActivationLog::class,
        InstallService::class => InstallService::class
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // This fixes some MySQL issues. Don't exactly know what it does... just don't touch it, okay?
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Bind request to ActivationGuard Facade
        $this->app->bind('ActivationGuard', function () {
            $request = app(Request::class);

            return app(ActivationGuard::class, [$request]);
        });
    }
}
