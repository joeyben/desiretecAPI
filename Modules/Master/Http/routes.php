<?php
$domain_env = array(
    'local_url' => 'master.com',
    'development_url' => 'master.reise-wunsch.com',
    'production_url' => 'master.reisewunschservice.de',
    'preproduction_url' => 'master.preprod.reisewunschservice.de',
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('master.id'));
    setTranslationLoaderModel(\Config::get('master.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Master\Http\Controllers', 'as' => 'master.'], function () {
        Route::get('/', 'MasterController@index');
        Route::get('show', 'MasterController@show');
        Route::get('store', 'MasterController@store')->name('store');
        Route::get('wish/{wish}', 'MasterWishesController@view')->name('wish.view');
        Route::get('wish/{wish}/{token}', 'MasterWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'MasterWishesController@getWish')->name('getWish');

    });
});

