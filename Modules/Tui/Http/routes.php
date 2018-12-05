<?php

Route::group(['domain' => '127.0.0.1'], function () {
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Tui\Http\Controllers'], function () {
        Route::get('/', 'TuiController@index');
        Route::get('show', 'TuiController@show');
        Route::post('store', 'TuiController@store')->name('store');
    });
});
