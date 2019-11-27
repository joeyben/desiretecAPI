<?php

$domain_env = [
    'local_url'       => 'testkurenundwellness.com',
    'development_url' => 'testkurenundwellness.reise-wunsch.com',
    'production_url'  => 'testkurenundwellness.reisewunschservice.de',
];

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('testkurenundwellness.id'));
    setTranslationLoaderModel(\Config::get('testkurenundwellness.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Testkurenundwellness\Http\Controllers', 'as' => 'testkurenundwellness.'], function () {
        Route::get('/', 'TestkurenundwellnessController@index');
        Route::get('show', 'TestkurenundwellnessController@show');
        Route::get('store', 'TestkurenundwellnessController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'TestkurenundwellnessWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'TestkurenundwellnessWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'TestkurenundwellnessWishesController@validateTokenList');
        Route::get('tnb', 'TestkurenundwellnessController@getPDF');
    });
});
