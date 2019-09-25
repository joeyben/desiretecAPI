<?php
$domain_env = array(
    'local_url' => 'lummerland.com',
    'development_url' => 'lummerland.reise-wunsch.com',
    'production_url' => 'lummerland.reisewunschservice.de',
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('lummerland.id'));
    setTranslationLoaderModel(\Config::get('lummerland.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Lummerland\Http\Controllers', 'as' => 'lummerland.'], function () {
        Route::get('/', 'LummerlandController@index');
        Route::get('show', 'LummerlandController@show');
        Route::get('store', 'LummerlandController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'LummerlandWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'LummerlandWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'LummerlandWishesController@validateTokenList');
    });
});

