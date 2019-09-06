<?php
$domain_env = array(
    'local_url' => 'dolphin.com',
    'development_url' => 'dolphin.reise-wunsch.com',
    'production_url' => 'dolphin.reisewunschservice.de',
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('dolphin.id'));
    setTranslationLoaderModel(\Config::get('dolphin.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Dolphin\Http\Controllers', 'as' => 'dolphin.'], function () {
        Route::get('/', 'DolphinController@index');
        Route::get('show', 'DolphinController@show');
        Route::get('store', 'DolphinController@store')->name('store');
        Route::get('wish/{wish}', 'DolphinWishesController@view')->name('wish.view');
        Route::get('wish/{wish}/{token}', 'DolphinWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'DolphinWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'DolphinWishesController@validateTokenList');
    });
});

