<?php

$domain_env = [
    'local_url'       => 'https://bild.com',
    'development_url' => 'https://bild.reise-wunsch.com',
    'production_url'  => 'https://bild.reisewunschservice.de',
];

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('bild.id'));
    setTranslationLoaderModel(\Config::get('bild.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Bild\Http\Controllers', 'as' => 'bild.'], function () {
        Route::get('/', 'BildController@index');
        Route::get('show', 'BildController@show');
        Route::get('store', 'BildController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'BildWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'BildWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'BildWishesController@validateTokenList');
    });
});
