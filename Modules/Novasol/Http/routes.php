<?php

Route::group(['domain' => 'novasol.reisewunschservice.de'], function () {
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Novasol\Http\Controllers', 'as' => 'novasol.'], function () {
        Route::get('/', 'NovasolController@index');
        Route::get('show', 'NovasolController@show');
        Route::get('store', 'NovasolController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'NovasolWishesController@details')->name('wish.details');
    });
});
