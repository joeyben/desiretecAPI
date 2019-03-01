<?php

Route::group(['domain' => 'master.com'], function () {
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Master\Http\Controllers', 'as' => 'master.'], function () {
        Route::get('/', 'MasterController@index');
        Route::get('show', 'MasterController@show');
        Route::get('store', 'MasterController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'MasterWishesController@details')->name('wish.details');
    });
});
