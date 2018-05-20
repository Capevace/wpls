<?php

namespace App\Providers;

use App\Auth\UserProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Auth::extend('access_token', function ($app, $name, array $config) {
        //     // automatically build the DI, put it as reference
        //     $userProvider = app(TokenToUserProvider::class);
        //     $request = app('request');
        //     return new AccessTokenGuard($userProvider, $request, $config);
        // });

        $this->app->auth->provider('custom', function ($app, array $config) {
            return new UserProvider($app['hash'], $config['model']);
        });
    }
}
