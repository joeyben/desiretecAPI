<?php
$domain_env = array(
    'local_url' => 'adventure.com',
    'development_url' => 'adventure.reise-wunsch.com',
    'production_url' => 'adventure.reisewunschservice.de',
    'preproduction_url' => 'adventure.preprod.reisewunschservice.de',
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('adventure.id'));
    setTranslationLoaderModel(\Config::get('adventure.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Adventure\Http\Controllers', 'as' => 'adventure.'], function () {
        Route::get('/', 'AdventureController@index');
        Route::get('show', 'AdventureController@show');
        Route::get('store', 'AdventureController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'AdventureWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'AdventureWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'AdventureWishesController@validateTokenList');
    });
});

