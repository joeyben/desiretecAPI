<?php

Route::group(['domain' => 'desiretec.reisewunschservice.de'], function () {
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\DesiretecReisewunschportal\Http\Controllers', 'as' => 'desiretecreisewunschportal.'], function () {
        Route::get('/', 'DesiretecReisewunschportalController@index');
        Route::get('show', 'DesiretecReisewunschportalController@show');
        Route::get('store', 'DesiretecReisewunschportalController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'DesiretecReisewunschportalWishesController@details')->name('wish.details');
    });
});
