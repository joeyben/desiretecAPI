<?php

Route::group(['domain' => 'tuilocal.com'], function () {
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Tui\Http\Controllers', 'as' => 'tui.'], function () {
        Route::get('/', 'TuiController@index');
        Route::get('show', 'TuiController@show');
        Route::get('store', 'TuiController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'TuiWishesController@details')->name('wish.details');
    });
});
