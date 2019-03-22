<?php

Route::group(['domain' => 'trendtours.reisewunschservice.de'], function () {
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Trendtours\Http\Controllers' , 'as' => 'trendtours.'], function () {
        Route::get('/', 'TrendtoursController@index');
        Route::get('show', 'TrendtoursController@show');
        Route::get('store', 'TrendtoursController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'TrendtoursWishesController@details')->name('wish.details');
    });
});
