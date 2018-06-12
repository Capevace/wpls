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

Route::prefix('v1')->group(function () {
	Route::get('/packages/{package}/metadata', 'PackageController@getMetadata');
	Route::get('/packages/{package}/download', 'PackageController@download')->name('package.download');

	Route::post('/license/activate', 'ActivationController@activate');
	Route::post('/license/deactivate', 'ActivationController@deactivate');
	Route::post('/activation/{activation}/deactivate', 'ActivationController@deactivateActivation');
});