<?php
$domain_env = array(
    'local_url' => 'traveloverland.com',
    'development_url' => 'traveloverland.reise-wunsch.com',
    'production_url' => 'traveloverland.reisewunschservice.de',
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('overland.id'));
    setTranslationLoaderModel(\Config::get('overland.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Overland\Http\Controllers', 'as' => 'traveloverland.'], function () {
        Route::get('/', 'OverlandController@index');
        Route::get('show', 'OverlandController@show');
        Route::get('store', 'OverlandController@store')->name('store');
        Route::get('wish/{wish}', 'OverlandWishesController@view')->name('wish.view');
        Route::get('wish/{wish}/{token}', 'OverlandWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'OverlandWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'OverlandWishesController@validateTokenList');
    });
});

