<?php

Route::group(['middleware' => 'web', 'prefix' => 'offer', 'namespace' => 'Modules\Autooffers\Http\Controllers', 'as' => 'autooffer.'], function () {
    Route::get('/', 'AutooffersController@index');
    Route::get('create/{wish}', 'AutooffersController@create')->name('create');
    Route::get('list/{wish}', 'AutooffersController@show')->name('list');
    Route::get('ttlist/{wish}', 'AutooffersController@showtt')->name('ttlist');
    Route::get('testTT', 'AutooffersController@testTT')->name('testtt');
    Route::get('testPW', 'AutooffersController@callPW')->name('peakwork');
    Route::get('olist/{wish}/{token}', 'AutooffersController@showttredirect')->name('ttlist_redirect');
    Route::get('details/{wish}/{index}', 'AutooffersController@details')->name('details');
    Route::get('ttdetails/{wish}/{index}', 'AutooffersController@ttdetails')->name('ttdetails');
    Route::post('store', 'AutooffersController@store')->name('store');
    Route::get('setting', 'AutooffersSettingController@index')->name('setting');
});

Route::group(['middleware' => 'web', 'prefix' => 'novasoloffer', 'namespace' => 'Modules\Autooffers\Http\Controllers', 'as' => 'autooffernovasol.'], function () {
    Route::get('/', 'AutooffersNovasolController@index');

    Route::get('create/{wish}', 'AutooffersNovasolController@create')->name('create');
    Route::get('list/{wish}', 'AutooffersNovasolController@show')->name('list');
    Route::get('to-the-offer/{wishid}', 'AutooffersNovasolController@toTheOffer')->name('to-the-offer');
    Route::get('details/{wish}', 'AutooffersNovasolController@details')->name('details');
    Route::post('store', 'AutooffersNovasolController@store')->name('store');
});

Route::group(['middleware' => ['web', 'auth', 'admin'], 'prefix' => 'admin', 'namespace' => 'Modules\Autooffers\Http\Controllers'], function () {
    Route::get('autooffers', 'AutooffersSettingController@index')->name('admin.autooffers');
    Route::get('autooffers/view', 'AutooffersSettingController@view')->name('admin.autooffers.view');
    Route::put('autooffers', 'AutooffersSettingController@store')->name('admin.autooffers.store');
    Route::get('autooffers/{id}', 'AutooffersSettingController@show')->name('admin.autooffers.show')->where('id', '[0-9]+');
    Route::get('autooffers/{id}/edit', 'AutooffersSettingController@edit')->name('admin.autooffers.edit')->where('id', '[0-9]+');
    Route::get('autooffers/create', 'AutooffersSettingController@create')->name('admin.autooffers.create');
    Route::put('autooffers/{id}', 'AutooffersSettingController@update')->name('admin.autooffers.update')->where('id', '[0-9]+');
    Route::delete('autooffers/{id}', 'AutooffersSettingController@destroy')->name('admin.autooffers.destroy')->where('id', '[0-9]+');
    Route::delete('autooffers/{id}/destroy', 'AutooffersSettingController@forceDelete')
        ->name('admin.autooffers.forceDelete')->where('id', '[0-9]+');
    Route::put('autooffers/{id}/restore', 'AutooffersSettingController@restore')->name('admin.autooffers.restore')->where('id', '[0-9]+');
    Route::get('autooffers/export', 'AutooffersSettingController@export')->name('admin.autooffers.export');
});
