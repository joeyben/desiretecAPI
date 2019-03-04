<?php

Route::group(['domain' => 'master.com'], function () {
    config(['app.current_whitelabel' => 'master']);
//    config(['translation-loader.model', \Config::get('master.language_lines_model')]);
//    dd(\Config::get('translation-loader.model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Master\Http\Controllers', 'as' => 'master.'], function () {
        Route::get('/', 'MasterController@index');
        Route::get('show', 'MasterController@show');
        Route::get('store', 'MasterController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'MasterWishesController@details')->name('wish.details');
    });
});
