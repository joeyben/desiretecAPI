<?php
$domain_env = array(
    'local_url' => 'https://urlaub.com',
    'development_url' => 'https://urlaub.reise-wunsch.com',
    'production_url' => 'https://urlaub.reisewunschservice.de',
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('urlaub.id'));
    setTranslationLoaderModel(\Config::get('urlaub.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Urlaub\Http\Controllers', 'as' => 'urlaub.'], function () {
        Route::get('/', 'UrlaubController@index');
        Route::get('show', 'UrlaubController@show');
        Route::get('store', 'UrlaubController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'UrlaubWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'UrlaubWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'UrlaubWishesController@validateTokenList');
        Route::get('tnb', 'UrlaubController@getPDF');
    });
});

