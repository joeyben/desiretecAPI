<?php

$domain_env = [
    'local_url'       => 'demoatw.com',
    'development_url' => 'demoatw.reise-wunsch.com',
    'production_url'  => 'demoatw.reisewunschservice.de',
];

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('demoatw.id'));
    setTranslationLoaderModel(\Config::get('demoatw.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Demoatw\Http\Controllers', 'as' => 'demoatw.'], function () {
        Route::get('/', 'DemoatwController@index');
        Route::get('show', 'DemoatwController@show');
        Route::get('store', 'DemoatwController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'DemoatwWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'DemoatwWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'DemoatwWishesController@validateTokenList');
    });
});
