<?php

Route::group(['middleware' => ['web', 'auth', 'admin'], 'prefix' => 'admin', 'namespace' => 'Modules\Categories\Http\Controllers'], function () {
    Route::get('categories', 'CategoriesController@index')->name('admin.categories');
    Route::get('categories/view', 'CategoriesController@view')->name('admin.categories.view');
    Route::get('categories/children/{id}', 'CategoriesController@children')
            ->name('admin.categories.children')
            ->where('id', '[0-9]+');
    Route::get('categories/childrenbyslug/{slug}', 'CategoriesController@childrenBySlug')
        ->name('admin.categories.childrenbyslug');
    Route::get('categories/{id}/edit', 'CategoriesController@edit')->name('admin.categories.edit')->where('id', '[0-9]+');
    Route::get('categories/create', 'CategoriesController@create')->name('admin.categories.create');
    Route::get('categories/append/{id}', 'CategoriesController@append')->name('admin.categories.append')->where('id', '[0-9]+');
    Route::delete('categories/{id}', 'CategoriesController@destroy')->name('admin.categories.destroy')->where('id', '[0-9]+');
    Route::put('categories/store', 'CategoriesController@store')->name('admin.categories.store');
    Route::put('categories/{id}', 'CategoriesController@update')->name('admin.categories.update')->where('id', '[0-9]+');
}
);
