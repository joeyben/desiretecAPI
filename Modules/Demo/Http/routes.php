<?php
$domain_env = array(
    'local_url' => 'demo.com',
    'development_url' => 'demo.reise-wunsch.com',
    'production_url' => 'demo.reisewunschservice.de',
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('demo.id'));
    setTranslationLoaderModel(\Config::get('demo.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Demo\Http\Controllers', 'as' => 'demo.'], function () {
        Route::get('/', 'DemoController@index');
        Route::get('show', 'DemoController@show');
        Route::get('store', 'DemoController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'DemoWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'DemoWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'DemoWishesController@validateTokenList');
    });
});

