<?php
$domain_env = array(
    'local_url' => 'testauto.com',
    'development_url' => 'testauto.reise-wunsch.com',
    'production_url' => 'testauto.reisewunschservice.de',
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('testauto.id'));
    setTranslationLoaderModel(\Config::get('testauto.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\TestAuto\Http\Controllers', 'as' => 'testauto.'], function () {
        Route::get('/', 'TestAutoController@index');
        Route::get('show', 'TestAutoController@show');
        Route::get('store', 'TestAutoController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'TestAutoWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'TestAutoWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'TestAutoWishesController@validateTokenList');
    });
});

