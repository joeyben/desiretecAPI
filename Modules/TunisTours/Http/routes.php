<?php

Route::group(['domain' => 'tunis.com'], function () {
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\TunisTours\Http\Controllers'], function () {
        Route::get('/', 'TunisToursController@index');
        Route::get('show', 'TunisToursController@show');
        Route::post('store', 'TunisToursController@store')->name('store');
    });
});
