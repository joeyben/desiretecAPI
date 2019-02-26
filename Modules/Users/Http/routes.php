<?php

Route::group(['middleware' => ['web', 'auth', 'admin', 'access.routeNeedsPermission:view-user-management'], 'prefix' => 'admin', 'namespace' => 'Modules\Users\Http\Controllers'], function () {
    Route::get('users', 'UsersController@index')->name('admin.users');
    Route::get('users/view', 'UsersController@view')->name('admin.users.view');
    Route::get('users/{id}/edit', 'UsersController@edit')->name('admin.users.edit')->where('id', '[0-9]+');
    Route::get('users/create', 'UsersController@create')->name('admin.users.create');
    Route::put('users/{id}', 'UsersController@update')->name('admin.users.update')->where('id', '[0-9]+');
    Route::put('users', 'UsersController@store')->name('admin.users.store');
});

Route::group(['middleware' => ['web', 'auth', 'admin', 'access.routeNeedsPermission:view-user-management'], 'prefix' => 'admin', 'namespace' => 'Modules\Users\Http\Controllers\Seller'], function () {
    Route::get('sellers/{id}/edit', 'SellersController@edit')->name('admin.sellers.edit')->where('id', '[0-9]+');
    Route::get('sellers/create', 'SellersController@create')->name('admin.sellers.create');
    Route::put('sellers/{id}', 'SellersController@update')->name('admin.sellers.update')->where('id', '[0-9]+');
    Route::put('sellers', 'SellersController@store')->name('admin.sellers.store');
    Route::get('sellers', 'SellersController@index')->name('admin.sellers');
    Route::get('sellers/view', 'SellersController@view')->name('admin.sellers.view');
});
