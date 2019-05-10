<?php

Route::group(['middleware' => 'web', 'prefix' => 'offer', 'namespace' => 'Modules\Autooffers\Http\Controllers', 'as' => 'autooffer.'], function () {
    Route::get('/', 'AutooffersController@index');
    Route::get('create/{wish}', 'AutooffersController@create')->name('create');
    Route::get('list/{wish}', 'AutooffersController@show')->name('list');
    Route::get('details/{wish}', 'AutooffersController@details')->name('details');
    Route::post('store', 'AutooffersController@store')->name('store');
});
