<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function ($request) {
	$action = $request->query('action');
	if ($action === 'get_metadata') {
		return redirect()->action('PackageController@getMetadata');
	} else if ($action === 'download') {

	} else if ($action === 'verify') {

	}
});

Route::get('/home', 'HomeController@index')->name('home');

// Auth routes
Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');


// Route::get('/login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
// Route::post('/register', 'App\Http\Controllers\Auth\LoginController@login');