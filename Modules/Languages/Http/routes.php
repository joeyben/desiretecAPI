<?php

Route::group(['middleware' => ['web', 'auth', 'admin'], 'prefix' => 'provider', 'namespace' => 'Modules\Languages\Http\Controllers'], function () {
    Route::get('languages', 'LanguagesController@index')->name('provider.languages');
    Route::get('languages/view', 'LanguagesController@view')->name('provider.languages.view');
    Route::get('languages/missing', 'LanguagesController@missing')->name('provider.languages.missing');
    Route::get('languages/list', 'LanguagesController@list')->name('provider.languages.list');
    Route::put('languages', 'LanguagesController@store')->name('provider.languages.store');
    Route::get('languages/{id}', 'LanguagesController@show')->name('provider.languages.show')->where('id', '[0-9]+');
    Route::get('languages/{id}/edit', 'LanguagesController@edit')->name('provider.languages.edit')->where('id', '[0-9]+');
    Route::get('languages/create', 'LanguagesController@create')->name('provider.languages.create')->where('id', '[0-9]+');
    Route::put('languages/{id}', 'LanguagesController@update')->name('provider.languages.update')->where('id', '[0-9]+');
    Route::delete('languages/{id}', 'LanguagesController@destroy')->name('provider.languages.destroy')->where('id', '[0-9]+');
    Route::delete('languages/{id}/destroy', 'LanguagesController@forceDelete')
        ->name('provider.languages.forceDelete')->where('id', '[0-9]+');
    Route::put('languages/{id}/restore', 'LanguagesController@restore')->name('provider.languages.restore')->where('id', '[0-9]+');
    Route::get('languages/export', 'LanguagesController@export')->name('provider.languages.export');
});
