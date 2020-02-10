<?php

$domain_env = [
    'local_url'       => 'https://bentour.com',
    'development_url' => 'https://bentour.reise-wunsch.com',
    'production_url'  => 'https://bentour.reisewunschservice.de',
];

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('bentour.id'));
    setTranslationLoaderModel(\Config::get('bentour.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Bentour\Http\Controllers', 'as' => 'bentour.'], function () {
        Route::get('/', 'BentourController@index');
        Route::get('show', 'BentourController@show');
        Route::get('store', 'BentourController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'BentourWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'BentourWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'BentourWishesController@validateTokenList');
    });
});
