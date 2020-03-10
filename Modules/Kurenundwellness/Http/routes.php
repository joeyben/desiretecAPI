<?php

$domain_env = [
    'local_url'       => 'kurenundwellness.com',
    'development_url' => 'kurenundwellness.reise-wunsch.com',
    'production_url'  => 'kurenundwellness.reisewunschservice.de',
];

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('kurenundwellness.id'));
    setTranslationLoaderModel(\Config::get('kurenundwellness.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Kurenundwellness\Http\Controllers', 'as' => 'kurenundwellness.'], function () {
        Route::get('/', 'KurenundwellnessController@index');
        Route::get('show', 'KurenundwellnessController@show');
        Route::get('store', 'KurenundwellnessController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'KurenundwellnessWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'KurenundwellnessWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'KurenundwellnessWishesController@validateTokenList');
    });
});
