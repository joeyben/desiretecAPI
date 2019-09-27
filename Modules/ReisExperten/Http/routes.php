<?php
$domain_env = array(
    'local_url' => 'reiseexperten.com',
    'development_url' => 'reiseexperten.reise-wunsch.com',
    'production_url' => 'reiseexperten.reisewunschservice.de',
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('reiseexperten.id'));
    setTranslationLoaderModel(\Config::get('reiseexperten.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\reiseexperten\Http\Controllers', 'as' => 'reiseexperten.'], function () {
        Route::get('/', 'reiseexpertenController@index');
        Route::get('show', 'reiseexpertenController@show');
        Route::get('store', 'reiseexpertenController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'reiseexpertenWishesController@details')->name('wish.details');
        Route::get('wish/{wish}', 'reiseexpertenWishesController@view')->name('wish.view');
        Route::get('getwish/{wish}', 'reiseexpertenWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'reiseexpertenWishesController@validateTokenList');
    });
});

