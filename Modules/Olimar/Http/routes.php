<?php

$domain_env = [
    'local_url'       => 'https://olimar.com',
    'development_url' => 'https://olimar.reise-wunsch.com',
    'production_url'  => 'https://olimar.reisewunschservice.de',
];

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('olimar.id'));
    setTranslationLoaderModel(\Config::get('olimar.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Olimar\Http\Controllers', 'as' => 'olimar.'], function () {
        Route::get('/', 'OlimarController@index');
        Route::get('show', 'OlimarController@show');
        Route::get('store', 'OlimarController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'OlimarWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'OlimarWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'OlimarWishesController@validateTokenList');
    });
});
