<?php

$domain_env = [
    'local_url'       => 'name.com',
    'development_url' => 'name.reise-wunsch.com',
    'production_url'  => 'name.reisewunschservice.de',
];

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('name.id'));
    setTranslationLoaderModel(\Config::get('name.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Name\Http\Controllers', 'as' => 'name.'], function () {
        Route::get('/', 'NameController@index');
        Route::get('show', 'NameController@show');
        Route::get('store', 'NameController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'NameWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'NameWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'NameWishesController@validateTokenList');
    });
});
