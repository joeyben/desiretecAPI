<?php
$domain_env = array(
    'local_url' => 'peruneu.com',
    'development_url' => 'peruneu.reise-wunsch.com',
    'production_url' => 'peruneu.reisewunschservice.de',
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('peruneu.id'));
    setTranslationLoaderModel(\Config::get('peruneu.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\PeruNeu\Http\Controllers', 'as' => 'peruneu.'], function () {
        Route::get('/', 'PeruNeuController@index');
        Route::get('show', 'PeruNeuController@show');
        Route::get('store', 'PeruNeuController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'PeruNeuWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'PeruNeuWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'PeruNeuWishesController@validateTokenList');
    });
});

