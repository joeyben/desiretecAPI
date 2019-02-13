<?php

Route::group(['middleware' => ['web', 'auth', 'admin'], 'prefix' => 'provider', 'namespace' => 'Modules\Groups\Http\Controllers'], function () {
    Route::get('groups', 'GroupsController@index')->name('provider.groups');
    Route::get('groups/view', 'GroupsController@view')->name('provider.groups.view');
    Route::put('groups', 'GroupsController@store')->name('provider.groups.store');
    Route::get('groups/{id}', 'GroupsController@show')->name('provider.groups.show')->where('id', '[0-9]+');
    Route::get('groups/{id}/edit', 'GroupsController@edit')->name('provider.groups.edit')->where('id', '[0-9]+');
    Route::get('groups/create', 'GroupsController@create')->name('provider.groups.create');
    Route::put('groups/{id}', 'GroupsController@update')->name('provider.groups.update')->where('id', '[0-9]+');
    Route::delete('groups/{id}', 'GroupsController@destroy')->name('provider.groups.destroy')->where('id', '[0-9]+');
    Route::delete('groups/{id}/destroy', 'GroupsController@forceDelete')
        ->name('provider.groups.forceDelete')->where('id', '[0-9]+');
    Route::put('groups/{id}/restore', 'GroupsController@restore')->name('provider.groups.restore')->where('id', '[0-9]+');
    Route::get('groups/export', 'GroupsController@export')->name('provider.groups.export');
});
