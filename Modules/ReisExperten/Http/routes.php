<?php
$domain_env = array(
    'local_url' => 'reisexperten.com',
    'development_url' => 'reisexperten.reise-wunsch.com',
    'production_url' => 'reisexperten.reisewunschservice.de',
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('reisexperten.id'));
    setTranslationLoaderModel(\Config::get('reisexperten.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\ReisExperten\Http\Controllers', 'as' => 'reisexperten.'], function () {
        Route::get('/', 'ReisExpertenController@index');
        Route::get('show', 'ReisExpertenController@show');
        Route::get('store', 'ReisExpertenController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'ReisExpertenWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'ReisExpertenWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'ReisExpertenWishesController@validateTokenList');
    });
});

