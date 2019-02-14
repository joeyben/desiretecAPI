<?php

Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Modules\Notifications\Http\Controllers'], function () {
    Route::get('notifications', 'NotificationsController@index')->name('notifications');
    Route::get('notifications/view', 'NotificationsController@view')->name('notifications.view');
    Route::put('notifications', 'NotificationsController@store')->name('notifications.store');
    Route::get('notifications/{id}', 'NotificationsController@show')->name('notifications.show')->where('id', '[0-9]+');
    Route::get('notifications/{id}/edit', 'NotificationsController@edit')->name('notifications.edit')->where('id', '[0-9]+');
    Route::get('notifications/create', 'NotificationsController@create')->name('notifications.create')->where('id', '[0-9]+');
    Route::put('notifications/{id}', 'NotificationsController@update')->name('notifications.update')->where('id', '[0-9]+');
    Route::delete('notifications/{id}', 'NotificationsController@destroy')->name('notifications.destroy')->where('id', '[0-9]+');
    Route::delete('notifications/{id}/destroy', 'NotificationsController@forceDelete')
        ->name('notifications.forceDelete')->where('id', '[0-9]+');
    Route::put('notifications/{id}/restore', 'NotificationsController@restore')->name('notifications.restore')->where('id', '[0-9]+');
});

Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Modules\Notifications\Http\Controllers'], function () {
    Route::get('inbox', 'InboxController@index')->name('inbox');
    Route::get('inbox/view', 'InboxController@view')->name('inbox.view');
    Route::put('inbox', 'InboxController@store')->name('inbox.store');
    Route::get('inbox/{id}', 'InboxController@show')->name('inbox.show')->where('id', '[0-9]+');
    Route::get('inbox/{id}/edit', 'InboxController@edit')->name('inbox.edit')->where('id', '[0-9]+');
    Route::get('inbox/create', 'InboxController@create')->name('inbox.create')->where('id', '[0-9]+');
    Route::put('inbox/{id}', 'InboxController@update')->name('inbox.update')->where('id', '[0-9]+');
    Route::put('inbox/read/{id}', 'InboxController@read')->name('notifications.read')->where('id', '[0-9]+');
    Route::put('inbox/readNotification', 'InboxController@readNotification')->name('notifications.readNotification');
    Route::delete('inbox/{id}', 'InboxController@destroy')->name('inbox.destroy')->where('id', '[0-9]+');
    Route::delete('inbox/{id}/destroy', 'InboxController@forceDelete')
        ->name('inbox.forceDelete')->where('id', '[0-9]+');
    Route::put('inbox/{id}/restore', 'InboxController@restore')->name('inbox.restore')->where('id', '[0-9]+');
});
