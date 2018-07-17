<?php

Route::get('/install', 'Setup\InstallController@index')->name('setup:install-form');
Route::post('/install/create-env', 'Setup\InstallController@createEnv')->name('setup:create-env');
Route::get('/install/test-db', 'Setup\InstallController@testDatabase')->name('setup:test-db');
Route::get('/install/success', 'Setup\InstallController@success')->name('setup:success');
Route::post('/install/create-admin', 'Setup\InstallController@createAdminAccount')->name('setup:create-admin');

Route::get('/update', 'Setup\UpdateController@index')->name('update:index');
Route::post('/update', 'Setup\UpdateController@update')->name('update:update');