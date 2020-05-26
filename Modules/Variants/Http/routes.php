<?php

Route::group(['middleware' => ['web', 'auth', 'admin'], 'prefix' => 'admin', 'namespace' => 'Modules\Variants\Http\Controllers'], function () {
    Route::get('variants', 'VariantsController@index')->name('admin.variants');
    Route::get('variants/view', 'VariantsController@view')->name('admin.variants.view');
    Route::put('variants', 'VariantsController@store')->name('admin.variants.store');
    Route::get('variants/{id}', 'VariantsController@show')->name('admin.variants.show')->where('id', '[0-9]+');
    Route::get('variants/{id}/edit', 'VariantsController@edit')->name('admin.variants.edit')->where('id', '[0-9]+');
    Route::get('variants/create', 'VariantsController@create')->name('admin.variants.create');
    Route::put('variants/{id}', 'VariantsController@update')->name('admin.variants.update')->where('id', '[0-9]+');
    Route::delete('variants/{id}', 'VariantsController@destroy')->name('admin.variants.destroy')->where('id', '[0-9]+');
    Route::delete('variants/{id}/destroy', 'VariantsController@forceDelete')
        ->name('admin.variants.forceDelete')->where('id', '[0-9]+');
    Route::put('variants/{id}/restore', 'VariantsController@restore')->name('admin.variants.restore')->where('id', '[0-9]+');
    Route::get('variants/export', 'VariantsController@export')->name('admin.variants.export');
});
