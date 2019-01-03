<?php

Route::group(['middleware' => ['web', 'auth', 'admin', 'access.routeNeedsPermission:view-access-management'], 'prefix' => 'admin', 'namespace' => 'Modules\Permissions\Http\Controllers'], function () {
    Route::get('permission/index', 'PermissionsController@index')->name('admin.access.permission.index');
    Route::get('permission/view', 'PermissionsController@view')->name('admin.access.permission.view');
});
