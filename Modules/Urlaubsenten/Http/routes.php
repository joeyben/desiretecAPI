<?php
$domain_env = array(
    'local_url' => 'https://urlaubsenten.com',
    'development_url' => 'https://urlaubsenten.reise-wunsch.com',
    'production_url' => 'https://urlaubsenten.reisewunschservice.de',
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('urlaubsenten.id'));
    setTranslationLoaderModel(\Config::get('urlaubsenten.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Urlaubsenten\Http\Controllers', 'as' => 'urlaubsenten.'], function () {
        Route::get('/', 'UrlaubsentenController@index');
        Route::get('show', 'UrlaubsentenController@show');
        Route::get('store', 'UrlaubsentenController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'UrlaubsentenWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'UrlaubsentenWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'UrlaubsentenWishesController@validateTokenList');
        //Route::get('tnb', 'UrlaubsentenController@getPDF');
    });
});

