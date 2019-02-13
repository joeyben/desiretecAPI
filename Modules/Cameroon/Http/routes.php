<?php

Route::group(['domain' => '.tui.cameroon.de'], function () {
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Cameroon\Http\Controllers'], function () {
        Route::get('/', 'CameroonController@index');
        Route::get('show', 'CameroonController@show');
        Route::post('store', 'CameroonController@store')->name('store');
    });
});
