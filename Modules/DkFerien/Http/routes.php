<?php
$domain_env = array(
    'local_url' => 'https://.com',
    'development_url' => 'https://.reise-wunsch.com',
    'production_url' => 'https://.reisewunschservice.de',
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('dkferien.id'));
    setTranslationLoaderModel(\Config::get('dkferien.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\DkFerien\Http\Controllers', 'as' => 'dkferien.'], function () {
        Route::get('/', 'DkFerienController@index');
        Route::get('show', 'DkFerienController@show');
        Route::get('store', 'DkFerienController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'DkFerienWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'DkFerienWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'DkFerienWishesController@validateTokenList');
    });
});

