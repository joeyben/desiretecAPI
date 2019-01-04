<?php

Route::group(['middleware' => ['web', 'auth', 'admin', 'access.routeNeedsPermission:view-access-management'], 'prefix' => 'admin', 'namespace' => 'Modules\Permissions\Http\Controllers'], function () {
    Route::get('permission', 'PermissionsController@index')->name('admin.permission');
    Route::get('permission/view', 'PermissionsController@view')->name('admin.permission.view');
});
