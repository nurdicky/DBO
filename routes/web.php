<?php

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
