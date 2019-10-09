<?php
$domain_env = array(
    'local_url' => 'testhafermann.com',
    'development_url' => 'testhafermann.reise-wunsch.com',
    'production_url' => 'testhafermann.reisewunschservice.de',
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('testhafermann.id'));
    setTranslationLoaderModel(\Config::get('testhafermann.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\TestHafermann\Http\Controllers', 'as' => 'testhafermann.'], function () {
        Route::get('/', 'TestHafermannController@index');
        Route::get('show', 'TestHafermannController@show');
        Route::get('store', 'TestHafermannController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'TestHafermannWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'TestHafermannWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'TestHafermannWishesController@validateTokenList');
    });
});

