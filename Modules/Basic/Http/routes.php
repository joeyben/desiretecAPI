<?php
$domain_env = array(
    'local_url' => 'http://basic.local',
    'development_url' => 'https://.reise-wunsch.com',
    'production_url' => 'https://.reisewunschservice.de',
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];





Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('basic.id'));
    setTranslationLoaderModel(\Config::get('basic.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Basic\Http\Controllers', 'as' => 'basic.'], function () {

        Route::get('/', 'BasicController@index');
        Route::get('show', 'BasicController@show');
        Route::get('store', 'BasicController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'BasicWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'BasicWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'BasicWishesController@validateTokenList');
        Route::get('tnb', 'BasicController@getPDF');
    });
});

