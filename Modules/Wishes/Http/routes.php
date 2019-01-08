<?php

Route::group(['middleware' => ['web', 'auth', 'admin'], 'prefix' => 'provider', 'namespace' => 'Modules\Wishes\Http\Controllers'], function () {
    Route::get('wishes', 'WishesController@index')->name('admin.wishes');
    Route::get('wishes/view', 'WishesController@view')->name('admin.wishes.view');
    Route::put('wishes', 'WishesController@store')->name('admin.wishes.store');
    Route::get('wishes/{id}', 'WishesController@show')->name('admin.wishes.show')->where('id', '[0-9]+');
    Route::get('wishes/{id}/edit', 'WishesController@edit')->name('admin.wishes.edit')->where('id', '[0-9]+');
    Route::get('wishes/create', 'WishesController@create')->name('admin.wishes.create')->where('id', '[0-9]+');
    Route::put('wishes/{id}', 'WishesController@update')->name('admin.wishes.update')->where('id', '[0-9]+');
    //Route::get('wishes/{id}/{token}', 'WishesController@token');
});
