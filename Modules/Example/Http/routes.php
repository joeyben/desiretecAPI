<?php
$domain_env = array(
    'local_url' => 'example.com',
    'development_url' => 'example.reise-wunsch.com',
    'production_url' => 'example.reisewunschservice.de',
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('example.id'));
    setTranslationLoaderModel(\Config::get('example.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Example\Http\Controllers', 'as' => 'example.'], function () {
        Route::get('/', 'ExampleController@index');
        Route::get('show', 'ExampleController@show');
        Route::get('store', 'ExampleController@store')->name('store');
        Route::get('wish/{wish}', 'ExampleWishesController@view')->name('wish.view');
        Route::get('wish/{wish}/{token}', 'ExampleWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'ExampleWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'ExampleWishesController@validateTokenList');
    });
});

