<?php

$domain_env = [
    'local_url'       => 'reiseexperten.com',
    'development_url' => 'reiseexperten.reise-wunsch.com',
    'production_url'  => 'reiseexperten.reisewunschservice.de',
];

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('reiseexperten.id'));
    setTranslationLoaderModel(\Config::get('reiseexperten.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Reiseexperten\Http\Controllers', 'as' => 'reiseexperten.'], function () {
        Route::get('/', 'ReiseexpertenController@index');
        Route::get('show', 'ReiseexpertenController@show');
        Route::get('store', 'ReiseexpertenController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'ReiseexpertenWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'ReiseexpertenWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'ReiseexpertenWishesController@validateTokenList');
    });
});
