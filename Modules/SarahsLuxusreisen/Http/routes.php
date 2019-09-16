<?php
$domain_env = array(
    'local_url' => 'sarahsluxusreisen.com',
    'development_url' => 'sarahsluxusreisen.reise-wunsch.com',
    'production_url' => 'sarahsluxusreisen.reisewunschservice.de',
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('sarahsluxusreisen.id'));
    setTranslationLoaderModel(\Config::get('sarahsluxusreisen.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\SarahsLuxusreisen\Http\Controllers', 'as' => 'sarahsluxusreisen.'], function () {
        Route::get('/', 'SarahsLuxusreisenController@index');
        Route::get('show', 'SarahsLuxusreisenController@show');
        Route::get('store', 'SarahsLuxusreisenController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'SarahsLuxusreisenWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'SarahsLuxusreisenWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'SarahsLuxusreisenWishesController@validateTokenList');
    });
});

