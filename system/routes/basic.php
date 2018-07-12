<?php

Route::get('/install', 'InstallController@index')->name('setup:install-form');
Route::post('/install', 'InstallController@install')->name('setup:install');
Route::get('/install/test', 'InstallController@testDatabase')->name('setup:test-db');
Route::get('/install/success', 'InstallController@success')->name('setup:success');
Route::post('/install/create-admin', 'InstallController@createAdminAccount')->name('setup:create-admin');

Route::get('/update', 'UpdateController@index')->name('update:index');
Route::post('/update', 'UpdateController@update')->name('update:update');