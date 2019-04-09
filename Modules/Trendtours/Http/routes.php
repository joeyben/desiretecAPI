<?php

Route::group(['domain' => 'https://trendtours.reisewunschservice.de'], function () {
    setCurrentWhiteLabelId(\Config::get('trendtours.id'));
    setTranslationLoaderModel(\Config::get('trendtours.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Trendtours\Http\Controllers' , 'as' => 'trendtours.'], function () {
        Route::get('/', 'TrendtoursController@index');
        Route::get('show', 'TrendtoursController@show');
        Route::get('store', 'TrendtoursController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'TrendtoursWishesController@details')->name('wish.details');
    });
});
