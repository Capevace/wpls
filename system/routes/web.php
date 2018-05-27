<?php

use Illuminate\Http\Request;

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

Route::get('/', function (Request $request) {
	$action = $request->query('action');
	if ($action === 'get_metadata') {
		return redirect()->action('PackageController@getMetadata');
	} else if ($action === 'download') {

	} else if ($action === 'verify') {

	}
});

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

// Route::get('/admin', function () {
// 	return view('admin');
// })->name('admin');

// Auth routes



// Route::get('/login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
// Route::post('/register', 'App\Http\Controllers\Auth\LoginController@login');