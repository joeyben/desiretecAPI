<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web', 'auth', 'admin', 'access.routeNeedsRole:Administrator'], 'prefix' => 'admin'], function () {
    Route::get('backups', 'BackupsController@index')->name('admin.backups');
    Route::get('backups/view', 'BackupsController@view')->name('admin.backups.view');
    Route::get('backups/create', 'BackupsController@create')->name('admin.backups.create');
    Route::get('backups/download/{file}', 'BackupsController@download')->name('admin.backups.download');
    Route::get('backups/show/{id}', 'BackupsController@show')->name('admin.backups.show')->where('id', '[0-9]+');
    Route::put('backups/update/{id}', 'BackupsController@update')->name('admin.backups.update')->where('id', '[0-9]+');
    Route::delete('backups/destroy/{file}', 'BackupsController@destroy')->name('admin.backups.destroy');
    Route::put('backups/restore/{id}', 'BackupsController@restore')->name('admin.backups.restore')->where('id', '[0-9]+');
});
