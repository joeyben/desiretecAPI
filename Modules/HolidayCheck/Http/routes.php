<?php

Route::group(['domain' => 'holidaycheckcom'], function () {
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\HolidayCheck\Http\Controllers'], function () {
        Route::get('/', 'HolidayCheckController@index');
        Route::get('show', 'HolidayCheckController@show');
        Route::post('store', 'HolidayCheckController@store')->name('store');
    });
});
