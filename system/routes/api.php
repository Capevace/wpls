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
	Route::get('/packages/{package}/metadata', 'PackageController@getMetadata');
	Route::get('/packages/{package}/download', 'PackageController@download');

	Route::post('/activate', 'ActivationController@activate');
	Route::post('/deactivate', 'ActivationController@deactivate');
});