<?php

Route::group(['middleware' => ['web', 'auth', 'admin'], 'prefix' => 'admin', 'namespace' => 'Modules\Regions\Http\Controllers'], function () {
    Route::get('regions', 'RegionsController@index')->name('admin.regions');
    Route::get('regions/view', 'RegionsController@view')->name('admin.regions.view');
    Route::put('regions', 'RegionsController@store')->name('admin.regions.store');
    Route::get('regions/{id}', 'RegionsController@show')->name('admin.regions.show')->where('id', '[0-9]+');
    Route::get('regions/{id}/edit', 'RegionsController@edit')->name('admin.regions.edit')->where('id', '[0-9]+');
    Route::get('regions/create', 'RegionsController@create')->name('admin.regions.create');
    Route::put('regions/{id}', 'RegionsController@update')->name('admin.regions.update')->where('id', '[0-9]+');
    Route::delete('regions/{id}', 'RegionsController@destroy')->name('admin.regions.destroy')->where('id', '[0-9]+');
    Route::delete('regions/{id}/destroy', 'RegionsController@forceDelete')
        ->name('admin.regions.forceDelete')->where('id', '[0-9]+');
    Route::put('regions/{id}/restore', 'RegionsController@restore')->name('admin.regions.restore')->where('id', '[0-9]+');
    Route::get('regions/export', 'RegionsController@export')->name('admin.regions.export');
});
