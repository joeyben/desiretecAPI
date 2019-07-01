<?php
$domain_env = array(
    'local_url' => 'johannes.com',
    'development_url' => 'johannes.reise-wunsch.com',
    'production_url' => 'johannes.reisewunschservice.de',
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('johannes.id'));
    setTranslationLoaderModel(\Config::get('johannes.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Johannes\Http\Controllers', 'as' => 'johannes.'], function () {
        Route::get('/', 'JohannesController@index');
        Route::get('show', 'JohannesController@show');
        Route::get('store', 'JohannesController@store')->name('store');
        Route::get('wish/{wish}', 'JohannesWishesController@view')->name('wish.view');
        Route::get('wish/{wish}/{token}', 'JohannesWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'JohannesWishesController@getWish')->name('getWish');

    });
});

