<?php

Route::group(['domain' => 'lima.com'], function () {
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Lima\Http\Controllers'], function () {
        Route::get('/', 'LimaController@index');
        Route::get('show', 'LimaController@show');
        Route::post('store', 'LimaController@store')->name('store');
    });
});
