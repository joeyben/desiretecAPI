<?php

Route::group(['middleware' => ['web', 'auth', 'admin'], 'prefix' => 'provider', 'namespace' => 'Modules\Dashboard\Http\Controllers'], function () {
    Route::get('dashboard', 'DashboardController@index')->name('provider.dashboard');
    Route::get('dashboard/view', 'DashboardController@view')->name('provider.dashboard.view');
    Route::put('dashboard', 'DashboardController@store')->name('provider.dashboard.store');
    Route::put('dashboard/save', 'DashboardController@save')->name('provider.dashboard.save');
    Route::get('dashboard/show', 'DashboardController@show')->name('provider.dashboard.show');
    Route::get('dashboard/{id}/edit', 'DashboardController@edit')->name('provider.dashboard.edit')->where('id', '[0-9]+');
    Route::get('dashboard/create', 'DashboardController@create')->name('provider.dashboard.create')->where('id', '[0-9]+');
    Route::get('dashboard/ga', 'DashboardController@googleAnalytics')->name('provider.dashboard.ga');
    Route::get('dashboard/analytics', 'DashboardController@backendAnalytics')->name('provider.dashboard.analytics');
    Route::put('dashboard/{id}', 'DashboardController@update')->name('provider.dashboard.update')->where('id', '[0-9]+');
    Route::delete('dashboard/{id}', 'DashboardController@destroy')->name('provider.dashboard.destroy')->where('id', '[0-9]+');
    Route::delete('dashboard/{id}/destroy', 'DashboardController@forceDelete')
        ->name('provider.dashboard.forceDelete')->where('id', '[0-9]+');
    Route::put('dashboard/{id}/restore', 'DashboardController@restore')->name('provider.dashboard.restore')->where('id', '[0-9]+');
});
