<?php

Route::group(['domain' => 'tui cameroon'], function () {
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\TuiCameroon\Http\Controllers'], function () {
        Route::get('/', 'TuiCameroonController@index');
        Route::get('show', 'TuiCameroonController@show');
        Route::post('store', 'TuiCameroonController@store')->name('store');
    });
});
