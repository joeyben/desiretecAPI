<?php

Route::group(['domain' => '127.0.0.1'], function () {
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Tui\Http\Controllers', 'as' => 'tui.'], function () {
        Route::get('/', 'TuiController@index');
        Route::get('show', 'TuiController@show');
        Route::get('store', 'TuiController@store')->name('store');
        Route::get('wish/{wish}?token={token}', 'TuiWishesController@details')->name('wish.details');
    });
});
