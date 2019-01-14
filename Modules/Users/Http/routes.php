<?php

Route::group(['middleware' => ['web', 'auth', 'admin', 'access.routeNeedsPermission:view-user-management'], 'prefix' => 'admin', 'namespace' => 'Modules\Users\Http\Controllers'], function () {
    Route::get('users', 'UsersController@index')->name('admin.users');
    Route::get('users/view', 'UsersController@view')->name('admin.users.view');
});
