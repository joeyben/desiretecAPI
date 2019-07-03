<?php
$domain_env = array(
    'local_url' => 'lastminute.com',
    'development_url' => 'lastminute.reise-wunsch.com',
    'production_url' => 'lastminute.reisewunschservice.de',
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('lastminute.id'));
    setTranslationLoaderModel(\Config::get('lastminute.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Lastminute\Http\Controllers', 'as' => 'lastminute.'], function () {
        Route::get('/', 'LastminuteController@index');
        Route::get('show', 'LastminuteController@show');
        Route::get('store', 'LastminuteController@store')->name('store');
        Route::get('wish/{wish}', 'LastminuteWishesController@view')->name('wish.view');
        Route::get('wish/{wish}/{token}', 'LastminuteWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'LastminuteWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'LastminuteWishesController@validateTokenList');
    });
});

