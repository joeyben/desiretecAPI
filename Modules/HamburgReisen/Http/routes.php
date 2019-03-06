<?php

Route::group(['domain' => 'hamburgreisen.reisewunschservice.de'], function () {
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\HamburgReisen\Http\Controllers' , 'as' => 'hamburgreisen.'], function () {
        Route::get('/', 'HamburgReisenController@index');
        Route::get('show', 'HamburgReisenController@show');
        Route::get('store', 'HamburgReisenController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'HamburgReisenWishesController@details')->name('wish.details');

    });
});
