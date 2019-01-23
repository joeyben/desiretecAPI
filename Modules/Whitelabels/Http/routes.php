<?php

Route::group(['middleware' => ['web', 'auth', 'admin'], 'prefix' => 'provider', 'namespace' => 'Modules\Whitelabels\Http\Controllers'], function () {
    Route::get('whitelabels', 'WhitelabelsController@index')->name('admin.whitelabels');
    Route::get('whitelabels/view', 'WhitelabelsController@view')->name('admin.whitelabels.view');
    Route::get('whitelabels/list', 'WhitelabelsController@list')->name('admin.whitelabels.list');
    Route::get('whitelabels/create', 'WhitelabelsController@create')->name('admin.whitelabels.create');
    Route::put('whitelabels', 'WhitelabelsController@store')->name('admin.whitelabels.store');
    Route::post('whitelabels/uploadFile', 'WhitelabelsController@uploadFile')->name('admin.whitelabels.uploadFile');
    Route::delete('whitelabels/destroyFile/{id}', 'WhitelabelsController@destroyFile')->name('admin.whitelabels.destroyFile');
    Route::get('whitelabels/{id}/edit', 'WhitelabelsController@edit')->name('admin.whitelabels.edit')->where('id', '[0-9]+');
    Route::put('whitelabels/{id}', 'WhitelabelsController@update')->name('admin.whitelabels.update')->where('id', '[0-9]+');
    Route::put('whitelabels/domain/{id}', 'WhitelabelsController@domain')->name('admin.whitelabels.domain')->where('id', '[0-9]+');
});
