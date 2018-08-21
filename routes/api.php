<?php

use Illuminate\Http\Request;

Route::post('auth/login', 'Api\AuthController@login');

Route::group(['middleware' => ['auth:api'] ], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::get('profile', 'Api\AuthController@profile');
        Route::post('update', 'Api\AuthController@update');
    });

    Route::group(['prefix' => 'mobil'], function () {
        Route::get('barcode/{barcode}', 'Api\CarController@barcode');
        Route::get('detail/{id}', 'Api\CarController@detail');
        Route::post('activate', 'Api\CarController@activation');    
    });

    Route::group(['prefix' => 'driver'], function () {
        Route::get('list/{car_id}', 'Api\DriverController@list');
        Route::post('create', 'Api\DriverController@create');
        Route::post('update/{id}', 'Api\DriverController@update');
    });

    Route::group(['prefix' => 'owner'], function () {
        Route::post('update/{id}', 'Api\OwnerController@update');
    });
    
    Route::group(['prefix' => 'log'], function () {
        Route::post('create', 'Api\LogController@transaction');
        Route::get('status', 'Api\LogController@getByDay');
    });

    Route::group(['prefix' => 'barcode'], function () {
        Route::get('check/{barcode}', 'Api\BarcodeController@check');
        
    });
});

