<?php

$domain_env = [
    'local_url'       => 'tuidemo.com',
    'development_url' => 'tuidemo.reise-wunsch.com',
    'production_url'  => 'tuidemo.reisewunschservice.de',
];

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('tuidemo.id'));
    setTranslationLoaderModel(\Config::get('tuidemo.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Tuidemo\Http\Controllers', 'as' => 'tuidemo.'], function () {
        Route::get('/', 'TuidemoController@index');
        Route::get('show', 'TuidemoController@show');
        Route::get('store', 'TuidemoController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'TuidemoWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'TuidemoWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'TuidemoWishesController@validateTokenList');
    });
});
