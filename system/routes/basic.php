<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Output\BufferedOutput;

Route::get('/install', 'InstallController@index')->name('setup:install-form');;
Route::post('/install', 'InstallController@install')->name('setup:install');
Route::get('/install/test', 'InstallController@testDatabase')->name('setup:test-db');

Route::get('/update', function() {
    $outputLog = new BufferedOutput;
    Artisan::call('migrate', ['--force' => true], $outputLog);

    return response('hello');
});