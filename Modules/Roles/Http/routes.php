<?php

Route::group(['middleware' => ['web', 'auth', 'admin', 'access.routeNeedsPermission:view-role-management'], 'prefix' => 'admin', 'namespace' => 'Modules\Roles\Http\Controllers'], function () {
    Route::get('roles', 'RolesController@index')->name('admin.roles');
    Route::get('roles/view', 'RolesController@view')->name('admin.roles.view');
});

