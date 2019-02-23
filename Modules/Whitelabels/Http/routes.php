<?php

Route::group(['middleware' => ['web', 'auth', 'admin', 'access.routeNeedsRole:' . \App\Services\Flag\Src\Flag::ADMINISTRATOR_ROLE], 'prefix' => 'admin', 'namespace' => 'Modules\Whitelabels\Http\Controllers'], function () {
    Route::get('whitelabels', 'WhitelabelsController@index')->name('admin.whitelabels');
    Route::get('whitelabels/view', 'WhitelabelsController@view')->name('admin.whitelabels.view');
    Route::get('whitelabels/list', 'WhitelabelsController@list')->name('admin.whitelabels.list');
    Route::get('whitelabels/create', 'WhitelabelsController@create')->name('admin.whitelabels.create');
    Route::put('whitelabels', 'WhitelabelsController@store')->name('admin.whitelabels.store');
    Route::get('whitelabels/{id}/edit', 'WhitelabelsController@edit')->name('admin.whitelabels.edit')->where('id', '[0-9]+');
    Route::put('whitelabels/{id}', 'WhitelabelsController@update')->name('admin.whitelabels.update')->where('id', '[0-9]+');
    Route::put('whitelabels/save/{id}', 'WhitelabelsController@save')->name('admin.whitelabels.save')->where('id', '[0-9]+');
    Route::put('whitelabels/domain/{id}', 'WhitelabelsController@domain')->name('admin.whitelabels.domain')->where('id', '[0-9]+');
    Route::delete('whitelabels/{id}', 'WhitelabelsController@destroy')->name('admin.whitelabels.destroy')->where('id', '[0-9]+');
    Route::delete('whitelabels/{id}/destroy', 'WhitelabelsController@forceDelete')
        ->name('admin.whitelabels.forceDelete')->where('id', '[0-9]+');
    Route::put('admin/{id}/restore', 'WhitelabelsController@restore')->name('admin.whitelabels.restore')->where('id', '[0-9]+');
});
