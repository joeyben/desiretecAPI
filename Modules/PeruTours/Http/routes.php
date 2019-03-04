<?php

Route::group(['domain' => 'peru.com'], function () {
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\PeruTours\Http\Controllers'], function () {
        Route::get('/', 'PeruToursController@index');
        Route::get('show', 'PeruToursController@show');
        Route::post('store', 'PeruToursController@store')->name('store');
    });
});
