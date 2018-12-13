<?php

Route::group(['middleware' => ['web', 'auth', 'admin'], 'prefix' => 'admin', 'namespace' => 'Modules\Components\Http\Controllers'], function () {
    Route::get('components', 'ComponentsController@index')->name('admin.components');
    Route::get('components/view', 'ComponentsController@view')->name('admin.components.view');
    Route::get('components/{id}/edit', 'ComponentsController@edit')->name('admin.components.edit')->where('id', '[0-9]+');
    Route::get('components/create', 'ComponentsController@create')->name('admin.components.create');
    Route::delete('components/{id}', 'ComponentsController@destroy')->name('admin.components.destroy')->where('id', '[0-9]+');
    Route::put('components/store', 'ComponentsController@store')->name('admin.components.store');
    Route::put('components/{id}', 'ComponentsController@update')->name('admin.components.update')->where('id', '[0-9]+');
}
);
