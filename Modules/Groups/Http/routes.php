<?php

Route::group(['middleware' => ['web', 'auth', 'admin'], 'prefix' => 'admin', 'namespace' => 'Modules\Groups\Http\Controllers'], function () {
    Route::get('groups', 'GroupsController@index')->name('admin.groups');
    Route::get('groups/view', 'GroupsController@view')->name('admin.groups.view');
    Route::put('groups', 'GroupsController@store')->name('admin.groups.store');
    Route::get('groups/{id}', 'GroupsController@show')->name('admin.groups.show')->where('id', '[0-9]+');
    Route::get('groups/{id}/edit', 'GroupsController@edit')->name('admin.groups.edit')->where('id', '[0-9]+');
    Route::get('groups/create', 'GroupsController@create')->name('admin.groups.create');
    Route::put('groups/{id}', 'GroupsController@update')->name('admin.groups.update')->where('id', '[0-9]+');
    Route::delete('groups/{id}', 'GroupsController@destroy')->name('admin.groups.destroy')->where('id', '[0-9]+');
    Route::delete('groups/{id}/destroy', 'GroupsController@forceDelete')
        ->name('admin.groups.forceDelete')->where('id', '[0-9]+');
    Route::put('groups/{id}/restore', 'GroupsController@restore')->name('admin.groups.restore')->where('id', '[0-9]+');
    Route::get('groups/export', 'GroupsController@export')->name('admin.groups.export');
});
