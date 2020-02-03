<?php

$domain_env = [
    'local_url'       => 'reiserebellen.com',
    'development_url' => 'reiserebellen.reise-wunsch.com',
    'production_url'  => 'reiserebellen.reisewunschservice.de',
];

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('reiserebellen.id'));
    setTranslationLoaderModel(\Config::get('reiserebellen.language_lines_model'));
    /*Route::group(['middleware' => 'web', 'prefix' => 'offerwl', 'namespace' => 'Modules\Reiserebellen\Http\Controllers', 'as' => 'autooffer.'], function () {
        Route::get('list/{wish}', 'ReiserebellenWishesController@list')->name('list');
        Route::get('create/{wish}', 'ReiserebellenWishesController@create')->name('create');
        Route::post('store', 'ReiserebellenWishesController@store')->name('store');
    });*/
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Reiserebellen\Http\Controllers', 'as' => 'reiserebellen.'], function () {
        Route::get('/', 'ReiserebellenController@index');
        Route::get('show', 'ReiserebellenController@show');
        Route::get('store', 'ReiserebellenController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'ReiserebellenWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'ReiserebellenWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'ReiserebellenWishesController@validateTokenList');
        Route::get('wishlist', 'ReiserebellenWishesController@wishList')->name('list');
    });
});
