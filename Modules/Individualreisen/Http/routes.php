<?php

$domain_env = [
    'local_url'       => 'individualreisen.com',
    'development_url' => 'individualreisen.reise-wunsch.com',
    'production_url'  => 'individualreisen.reisewunschservice.de',
];

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('individualreisen.id'));
    setTranslationLoaderModel(\Config::get('individualreisen.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Individualreisen\Http\Controllers', 'as' => 'individualreisen.'], function () {
        Route::get('/', 'IndividualreisenController@index');
        Route::get('show', 'IndividualreisenController@show');
        Route::get('store', 'IndividualreisenController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'IndividualreisenWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'IndividualreisenWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'IndividualreisenWishesController@validateTokenList');
    });
});
