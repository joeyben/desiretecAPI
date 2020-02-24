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
    Route::get('whitelabels/show/{id}', 'WhitelabelsController@show')->name('admin.whitelabels.show')->where('id', '[0-9]+');
    Route::delete('whitelabels/{id}', 'WhitelabelsController@destroy')->name('admin.whitelabels.destroy')->where('id', '[0-9]+');
    Route::delete('whitelabels/{id}/destroy', 'WhitelabelsController@forceDelete')
        ->name('admin.whitelabels.forceDelete')->where('id', '[0-9]+');
    Route::put('admin/{id}/restore', 'WhitelabelsController@restore')->name('admin.whitelabels.restore')->where('id', '[0-9]+');

    Route::get('whitelabels/layers', 'LayersController@index')->name('admin.whitelabels.layers');
    Route::put('whitelabels/layers/update', 'LayersController@update')->name('admin.whitelabels.layers.update');
    Route::get('whitelabels/current', 'WhitelabelsController@current')->name('admin.whitelabels.current');
});

Route::group(['middleware' => ['web', 'auth', 'admin', 'access.routeNeedsRole:' . \App\Services\Flag\Src\Flag::EXECUTIVE_ROLE], 'prefix' => 'admin', 'namespace' => 'Modules\Whitelabels\Http\Controllers'], function () {
    Route::get('whitelabels/show/{id}', 'WhitelabelsController@show')->name('admin.whitelabels.show')->where('id', '[0-9]+');
    Route::get('whitelabels/layers', 'LayersController@index')->name('admin.whitelabels.layers');
    Route::get('whitelabels/layers/view', 'LayersController@view')->name('admin.whitelabels.layers.view');
    Route::put('whitelabels/layers/update', 'LayersController@update')->name('admin.whitelabels.layers.update');
    Route::get('whitelabels/current', 'WhitelabelsController@current')->name('admin.whitelabels.current');
});

Route::group(['middleware' => ['web', 'auth', 'admin', 'access.routeNeedsRole:' . \App\Services\Flag\Src\Flag::EXECUTIVE_ROLE], 'prefix' => 'admin', 'namespace' => 'Modules\Whitelabels\Http\Controllers'], function () {
    Route::get('whitelabels/content/view', 'LayersContentController@view')->name('admin.whitelabels.content.view');
    Route::get('whitelabels/content', 'LayersContentController@index')->name('admin.whitelabels.content');
    Route::put('whitelabels/content/update', 'LayersContentController@update')->name('admin.whitelabels.content.update');
});

Route::group(['middleware' => ['web', 'auth', 'admin', 'access.routeNeedsRole:' . \App\Services\Flag\Src\Flag::EXECUTIVE_ROLE], 'prefix' => 'provider', 'namespace' => 'Modules\Whitelabels\Http\Controllers\Provider'], function () {
    Route::get('whitelabels', 'WhitelabelsController@index')->name('provider.whitelabels');
    Route::put('whitelabels/save/{id}', 'WhitelabelsController@save')->name('provider.whitelabels.save')->where('id', '[0-9]+');
});

Route::group(['middleware' => ['web', 'auth', 'admin', 'access.routeNeedsRole:' . \App\Services\Flag\Src\Flag::EXECUTIVE_ROLE], 'prefix' => 'provider', 'namespace' => 'Modules\Whitelabels\Http\Controllers\Provider'], function () {
    Route::post('whitelabels/store', 'HostsController@store')->name('provider.hosts.store');
    Route::delete('whitelabels/{host}', 'HostsController@destroy')->name('provider.hosts.destroy');
});
