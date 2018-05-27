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
	Route::get('/', function() {
		return view('admin.index');
	});

	Route::prefix('api')->group(function() {
		Route::get('/activations');
		Route::get('/licenses');
		Route::get('/packages');
		Route::get('/sites');
	});
});