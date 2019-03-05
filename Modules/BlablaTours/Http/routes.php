<?php

Route::group(['domain' => 'test.com'], function () {
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\BlablaTours\Http\Controllers' , 'as' => 'blablatours.'], function () {
        Route::get('/', 'BlablaToursController@index');
        Route::get('show', 'BlablaToursController@show');
        Route::get('store', 'BlablaToursController@store')->name('store');
    });
});
