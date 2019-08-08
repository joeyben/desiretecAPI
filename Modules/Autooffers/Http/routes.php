<?php

Route::group(['middleware' => 'web', 'prefix' => 'offer', 'namespace' => 'Modules\Autooffers\Http\Controllers', 'as' => 'autooffer.'], function () {
    Route::get('/', 'AutooffersController@index');
    Route::get('create/{wish}', 'AutooffersController@create')->name('create');
    Route::get('list/{wish}', 'AutooffersController@show')->name('list');
    Route::get('details/{wish}', 'AutooffersController@details')->name('details');
    Route::post('store', 'AutooffersController@store')->name('store');
});

Route::group(['middleware' => 'web', 'prefix' => 'novasoloffer', 'namespace' => 'Modules\Autooffers\Http\Controllers', 'as' => 'autooffer.'], function () {
    Route::get('/', 'AutooffersNovasolController@index');

    Route::get('create/{wish}', 'AutooffersNovasolController@create')->name('create');
    Route::get('list/{wish}', 'AutooffersNovasolController@show')->name('list');
    Route::get('to-the-offer/{wishid}', 'AutooffersNovasolController@toTheOffer')->name('to-the-offer');
    Route::get('details/{wish}', 'AutooffersNovasolController@details')->name('details');
    Route::post('store', 'AutooffersNovasolController@store')->name('store');
});
