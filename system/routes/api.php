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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
	Route::get('/package/{package}', 'PackageController@get');
	Route::get('/package/{package}/metadata', 'PackageController@getMetadata')->middleware('auth.activation');
	Route::get('/package/{package}/download', 'PackageController@download');

	Route::post('/activate', 'ActivationController@activate');
	Route::post('/deactivate', 'ActivationController@deactivate');
	Route::get('/license/{license}', 'LicenseController@get');
});

Route::middleware('auth')->prefix('admin')->group(function() {
	Route::get('/activations');
	Route::get('/licenses');
	Route::get('/packages');
	Route::get('/sites');
});