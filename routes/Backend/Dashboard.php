<?php

/**
 * All route names are prefixed with 'admin.'.
 */
Route::post('get-permission', 'DashboardController@getPermissionByRole')->name('get.permission');

/*
 * Edit Profile
*/
Route::get('profile/edit', 'DashboardController@editProfile')->name('profile.edit');
Route::patch('profile/update', 'DashboardController@updateProfile')
    ->name('profile.update');
