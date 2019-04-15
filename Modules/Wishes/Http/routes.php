<?php

Route::group(['middleware' => ['web', 'auth', 'admin'], 'prefix' => 'admin', 'namespace' => 'Modules\Wishes\Http\Controllers'], function () {
    Route::get('wishes', 'WishesController@index')->name('admin.wishes');
    Route::get('wishes/view', 'WishesController@view')->name('admin.wishes.view');
    Route::put('wishes', 'WishesController@store')->name('admin.wishes.store');
    Route::get('wishes/{id}', 'WishesController@show')->name('admin.wishes.show')->where('id', '[0-9]+');
    Route::get('wishes/{id}/edit', 'WishesController@edit')->name('admin.wishes.edit')->where('id', '[0-9]+');
    Route::get('wishes/create', 'WishesController@create')->name('admin.wishes.create')->where('id', '[0-9]+');
    Route::put('wishes/{id}', 'WishesController@update')->name('admin.wishes.update')->where('id', '[0-9]+');
    Route::get('wishes/export', 'WishesController@export')->name('admin.wishes.export');

    Route::delete('wishes/{id}', 'WishesController@destroy')->name('admin.wishes.destroy')->where('id', '[0-9]+');
    Route::delete('wishes/{id}/destroy', 'WishesController@forceDelete')
        ->name('admin.wishes.forceDelete')->where('id', '[0-9]+');
    Route::put('wishes/{id}/restore', 'WishesController@restore')->name('admin.wishes.restore')->where('id', '[0-9]+');
});
