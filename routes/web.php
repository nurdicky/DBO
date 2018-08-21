<?php

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('import-csv', array('as'=>'excel.import','uses'=>'HomeController@importExportExcelORCSV'));
    Route::post('import-csv-excel', array('as'=>'import-csv-excel','uses'=>'HomeController@importFileIntoDB'));

    // Route::get('auth/{provider}', 'LoginController@redirect');
    // Route::get('auth/{provider}/callback', 'LoginController@callback');

    // Route::prefix('sheets')->namespace('Sheets')->group(function () {
    //     Route::name('sheets.index')->get('/', 'IndexController@index');
    //     Route::name('sheets.show')->get('/{spreadsheet_id}', 'ShowController');
    //     Route::name('sheets.sheet')->get('/{spreadsheet_id}/sheet/{sheet_id}', 'SheetController');
    // });

    // Route::post('/sync', 'HomeController@sync')->name('sync');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/print/barcode', 'HomeController@print')->name('print.barcode');
    Route::get('/home/count/{date}', 'HomeController@filterByDate')->name('count');

    Route::get('employee/export', 'EmployeeController@export')->name('employee.export');
    Route::resource('employee', 'EmployeeController');

    Route::group(['prefix' => 'master'], function () {
        Route::get('owner/export', 'OwnerController@export')->name('owner.export');
        Route::resource('owner', 'OwnerController');
        Route::get('driver/export', 'DriverController@export')->name('driver.export');    
        Route::resource('driver', 'DriverController');
        Route::get('/barcode/{number?}', 'CarController@barcode')->name('barcode');
        Route::get('car/export', 'CarController@export')->name('car.export');
        Route::resource('car', 'CarController');

    });

    Route::get('log/export', 'LogController@export')->name('log.export');
    Route::resource('log', 'LogController');
    Route::get('/masuk', 'LogController@masuk')->name('log.masuk');
    Route::get('/keluar', 'LogController@keluar')->name('log.keluar');
    Route::get('/rekap', 'HomeController@rekap')->name('rekap.index');
    Route::get('/rekap/filter/{start}/{end}', 'HomeController@report')->name('rekap.filter');
    Route::get('/rekap/export/{start}/{end}', 'HomeController@export')->name('export.excel');
 
});