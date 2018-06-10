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

		Route::get('/licenses', 'LicenseController@all');
		Route::post('/licenses', 'LicenseController@create'); // create new license
		Route::post('/licenses/{license}/invalidate', 'LicenseController@invalidate');
		Route::post('/licenses/{license}/delete', 'LicenseController@delete');


		Route::get('/packages', 'PackageController@all');
		Route::post('/packages/{package}/envato-item-id', 'PackageController@updateEnvatoItemId');
		Route::post('/packages/{package}/test-license', 'PackageController@testLicense');

		//Route::get('/sites');
	});
});