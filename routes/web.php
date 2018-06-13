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

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();

Route::post('/sync', 'HomeController@sync')->name('sync');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('auth/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::resource('employee', 'EmployeeController');

Route::group(['prefix' => 'master'], function () {
    Route::resource('owner', 'OwnerController');
    Route::resource('driver', 'DriverController');
    Route::resource('car', 'CarController');
});
