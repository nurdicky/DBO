<?php

use Illuminate\Http\Request;

Route::post('auth/login', 'Api\AuthController@login');

Route::group(['middleware' => ['auth:api'] ], function () {
    Route::group(['prefix' => 'user'], function () {
        Route::get('profile', 'Api\AuthController@profile');
        Route::post('update', 'Api\AuthController@update');
        Route::get('profile', 'Api\AuthController@profile');    
    });

    Route::group(['prefix' => 'mobil'], function () {
        Route::get('barcode/{barcode}', 'Api\AuthController@barcode');
        Route::post('activate', 'Api\AuthController@activation');    
    });
    
});

