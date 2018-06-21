<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth')->group(function () {
	Route::get('/', 'WebController@index');

	Route::prefix('api')->group(function() {
		Route::get('/activations', 'ActivationController@all');

		// License Routes
		Route::get('/licenses', 'LicenseController@all');
		Route::post('/licenses/create', 'LicenseController@create'); // create new license
		Route::post('/licenses/{license}/invalidate', 'LicenseController@invalidate');
		Route::post('/licenses/{license}/delete', 'LicenseController@delete');

		// Package Routes
		Route::get('/packages', 'PackageController@all');
		Route::post('/packages/create', 'PackageController@create');
		Route::post('/packages/{package}/envato-item-id', 'PackageController@updateEnvatoItemId');
		Route::post('/packages/{package}/test-license', 'PackageController@testLicense');
		Route::post('/packages/{package}/update', 'PackageController@update');
		Route::post('/packages/{package}/delete', 'PackageController@delete');

		// Announcement Routes
		Route::get('/announcements', 'AnnouncementController@all');
		Route::post('/announcements/create', 'AnnouncementController@create');
		Route::get('/announcements/{announcement}', 'AnnouncementController@get');
		Route::post('/announcements/{announcement}/delete', 'AnnouncementController@delete');

		//Route::get('/sites');
	});
});