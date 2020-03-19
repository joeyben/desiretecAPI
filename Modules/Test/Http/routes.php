<?php

$domain_env = [
    'local_url'       => 'http://test.local',
    'development_url' => 'https://test.reise-wunsch.com',
    'production_url'  => 'https://test.reisewunschservice.de',
];

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('test.id'));
    setTranslationLoaderModel(\Config::get('test.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Test\Http\Controllers', 'as' => 'test.'], function () {
        Route::get('/', 'TestController@index');
        Route::get('show', 'TestController@show');
        Route::get('store', 'TestController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'TestWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'TestWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'TestWishesController@validateTokenList');
    });
});
