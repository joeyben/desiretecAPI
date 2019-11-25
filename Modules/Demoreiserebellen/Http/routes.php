<?php

$domain_env = [
    'local_url'       => 'demoreiserebellen.com',
    'development_url' => 'demoreiserebellen.reise-wunsch.com',
    'production_url'  => 'demoreiserebellen.reisewunschservice.de',
];

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('demoreiserebellen.id'));
    setTranslationLoaderModel(\Config::get('demoreiserebellen.language_lines_model'));
    /*Route::group(['middleware' => 'web', 'prefix' => 'offerwl', 'namespace' => 'Modules\Demoreiserebellen\Http\Controllers', 'as' => 'autooffer.'], function () {
        Route::get('list/{wish}', 'DemoreiserebellenWishesController@list')->name('list');
        Route::get('create/{wish}', 'DemoreiserebellenWishesController@create')->name('create');
        Route::post('store', 'DemoreiserebellenWishesController@store')->name('store');
    });*/
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Demoreiserebellen\Http\Controllers', 'as' => 'demoreiserebellen.'], function () {
        Route::get('/', 'DemoreiserebellenController@index');
        Route::get('show', 'DemoreiserebellenController@show');
        Route::get('store', 'DemoreiserebellenController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'DemoreiserebellenWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'DemoreiserebellenWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'DemoreiserebellenWishesController@validateTokenList');
        Route::get('wishlist', 'DemoreiserebellenWishesController@wishList')->name('list');
    });
});
