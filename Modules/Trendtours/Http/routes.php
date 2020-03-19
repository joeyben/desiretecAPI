<?php

$domain_env = [
    'local_url'       => 'https://trendtours.com',
    'development_url' => 'https://trendtours.reise-wunsch.com',
    'production_url'  => 'https://trendtours.reisewunschservice.de',
];

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('trendtours.id'));
    setTranslationLoaderModel(\Config::get('trendtours.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Trendtours\Http\Controllers', 'as' => 'trendtours.'], function () {
        Route::get('/', 'TrendtoursController@index');
        Route::get('show', 'TrendtoursController@show');
        Route::get('store', 'TrendtoursController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'TrendtoursWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'TrendtoursWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'TrendtoursWishesController@validateTokenList');
    });
});
