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
    Route::get('notifications/export', 'NotificationsController@export')->name('notifications.export');
});
