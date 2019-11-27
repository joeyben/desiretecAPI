<?php
$domain_env = array(
    'local_url' => 'https://desiretecdemo.com',
    'development_url' => 'https://desiretecdemo.reise-wunsch.com',
    'production_url' => 'https://desiretecdemo.reisewunschservice.de',
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('desiretecdemo.id'));
    setTranslationLoaderModel(\Config::get('desiretecdemo.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\DesiretecDemo\Http\Controllers', 'as' => 'desiretecdemo.'], function () {
        Route::get('/', 'DesiretecDemoController@index');
        Route::get('show', 'DesiretecDemoController@show');
        Route::get('store', 'DesiretecDemoController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'DesiretecDemoWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'DesiretecDemoWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'DesiretecDemoWishesController@validateTokenList');
    });
});

