<?php

Route::group(['middleware' => ['web', 'auth', 'admin'], 'prefix' => 'admin', 'namespace' => 'Modules\Footers\Http\Controllers'], function () {
    Route::get('footers', 'FootersController@index')->name('admin.footers');
    Route::get('footers/view', 'FootersController@view')->name('admin.footers.view');
    Route::put('footers', 'FootersController@store')->name('admin.footers.store');
    Route::get('footers/{id}', 'FootersController@show')->name('admin.footers.show')->where('id', '[0-9]+');
    Route::get('footers/{id}/edit', 'FootersController@edit')->name('admin.footers.edit')->where('id', '[0-9]+');
    Route::get('footers/create', 'FootersController@create')->name('admin.footers.create');
    Route::put('footers/{id}', 'FootersController@update')->name('admin.footers.update')->where('id', '[0-9]+');
    Route::delete('footers/{id}', 'FootersController@destroy')->name('admin.footers.destroy')->where('id', '[0-9]+');
    Route::delete('footers/{id}/destroy', 'FootersController@forceDelete')
        ->name('admin.footers.forceDelete')->where('id', '[0-9]+');
    Route::put('footers/{id}/restore', 'FootersController@restore')->name('admin.footers.restore')->where('id', '[0-9]+');
    Route::get('footers/export', 'FootersController@export')->name('admin.footers.export');
});
