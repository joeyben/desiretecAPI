<?php

Route::group(['middleware' => 'web', 'prefix' => 'offer', 'namespace' => 'Modules\Autooffers\Http\Controllers', 'as' => 'autooffer.'], function () {
    Route::get('/', 'AutooffersController@index');
    Route::get('create/{wish}', 'AutooffersController@create')->name('create');
    Route::get('details/{wish}', 'AutooffersController@show')->name('details');
    Route::post('store', 'AutooffersController@store')->name('store');
});
