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
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Dolphin\Http\Controllers', 'as' => 'shark.'], function () {
        Route::get('/', 'DolphinController@index');
        Route::get('show', 'DolphinController@show');
        Route::get('store', 'DolphinController@store')->name('store');
        Route::get('wish/{wish}', 'DolphinWishesController@view')->name('wish.view');
        Route::get('wish/{wish}/{token}', 'DolphinWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'DolphinWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'DolphinWishesController@validateTokenList');
    });
});

