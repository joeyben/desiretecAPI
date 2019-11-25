<?php

$domain_env = [
    'local_url'       => 'fn.com',
    'development_url' => 'fn.reise-wunsch.com',
    'production_url'  => 'fn.reisewunschservice.de',
];

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('fn.id'));
    setTranslationLoaderModel(\Config::get('fn.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\FN\Http\Controllers', 'as' => 'fn.'], function () {
        Route::get('/', 'FNController@index');
        Route::get('show', 'FNController@show');
        Route::get('store', 'FNController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'FNWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'FNWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'FNWishesController@validateTokenList');
    });
});
