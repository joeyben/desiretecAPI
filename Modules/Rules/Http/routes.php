<?php

Route::group(['middleware' => ['web', 'auth', 'admin'], 'prefix' => 'admin', 'namespace' => 'Modules\Rules\Http\Controllers'], function () {
    Route::get('rules', 'RulesController@index')->name('admin.rules');
    Route::get('rules/view', 'RulesController@view')->name('admin.rules.view');
    Route::put('rules', 'RulesController@store')->name('admin.rules.store');
    Route::get('rules/{id}', 'RulesController@show')->name('admin.rules.show')->where('id', '[0-9]+');
    Route::get('rules/{id}/edit', 'RulesController@edit')->name('admin.rules.edit')->where('id', '[0-9]+');
    Route::get('rules/create', 'RulesController@create')->name('admin.rules.create');
    Route::put('rules/{id}', 'RulesController@update')->name('admin.rules.update')->where('id', '[0-9]+');
    Route::delete('rules/{id}', 'RulesController@destroy')->name('admin.rules.destroy')->where('id', '[0-9]+');
    Route::delete('rules/{id}/destroy', 'RulesController@forceDelete')
        ->name('admin.rules.forceDelete')->where('id', '[0-9]+');
    Route::put('rules/{id}/restore', 'RulesController@restore')->name('admin.rules.restore')->where('id', '[0-9]+');
    Route::get('rules/export', 'RulesController@export')->name('admin.rules.export');
});

