<?php
$domain_env = array(
    'local_url' => 'shark.com',
    'development_url' => 'shark.reise-wunsch.com',
    'production_url' => 'shark.reisewunschservice.de',
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('shark.id'));
    setTranslationLoaderModel(\Config::get('shark.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Shark\Http\Controllers', 'as' => 'shark.'], function () {
        Route::get('/', 'SharkController@index');
        Route::get('show', 'SharkController@show');
        Route::get('store', 'SharkController@store')->name('store');
        Route::get('wish/{wish}', 'SharkWishesController@view')->name('wish.view');
        Route::get('wish/{wish}/{token}', 'SharkWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'SharkWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'SharkWishesController@validateTokenList');
    });
});

