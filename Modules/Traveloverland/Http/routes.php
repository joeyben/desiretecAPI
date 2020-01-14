<?php

$domain_env = [
    'local_url'       => 'traveloverland.com',
    'development_url' => 'traveloverland.reise-wunsch.com',
    'production_url'  => 'traveloverland.reisewunschservice.de',
];

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('traveloverland.id'));
    setTranslationLoaderModel(\Config::get('traveloverland.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Traveloverland\Http\Controllers', 'as' => 'traveloverland.'], function () {
        Route::get('/', 'TraveloverlandController@index');
        Route::get('show', 'TraveloverlandController@show');
        Route::get('store', 'TraveloverlandController@store')->name('store');
        Route::get('wish/{wish}', 'TraveloverlandWishesController@view')->name('wish.view');
        Route::get('wish/{wish}/{token}', 'TraveloverlandWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'TraveloverlandWishesController@getWish')->name('getWish');
        Route::get('wishlist', 'TraveloverlandWishesController@wishList')->name('list');
        Route::get('wishlist/{token}', 'TraveloverlandWishesController@validateTokenList');
//        Route::get('tnb', 'TraveloverlandController@getPDF');
    });
});
