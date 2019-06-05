<?php

Route::group(['middleware' => ['web', 'auth', 'admin'], 'prefix' => 'admin', 'namespace' => 'Modules\Dashboard\Http\Controllers'], function () {
    Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');
    Route::get('dashboard/view', 'DashboardController@view')->name('admin.dashboard.view');
    Route::put('dashboard', 'DashboardController@store')->name('admin.dashboard.store');
    Route::put('dashboard/save', 'DashboardController@save')->name('admin.dashboard.save');
    Route::get('dashboard/show', 'DashboardController@show')->name('admin.dashboard.show');
    Route::get('dashboard/{id}/edit', 'DashboardController@edit')->name('admin.dashboard.edit')->where('id', '[0-9]+');
    Route::get('dashboard/create', 'DashboardController@create')->name('admin.dashboard.create')->where('id', '[0-9]+');
    Route::get('dashboard/ga', 'DashboardController@googleAnalytics')->name('admin.dashboard.ga');
    Route::get('dashboard/analytics', 'DashboardController@backendAnalytics')->name('admin.dashboard.analytics');
    Route::put('dashboard/{id}', 'DashboardController@update')->name('admin.dashboard.update')->where('id', '[0-9]+');
    Route::delete('dashboard/{id}', 'DashboardController@destroy')->name('admin.dashboard.destroy')->where('id', '[0-9]+');
    Route::delete('dashboard/{id}/destroy', 'DashboardController@forceDelete')
        ->name('admin.dashboard.forceDelete')->where('id', '[0-9]+');
    Route::put('dashboard/{id}/restore', 'DashboardController@restore')->name('admin.dashboard.restore')->where('id', '[0-9]+');

    Route::get('dashboard/wishes', 'WishesController@index')->name('admin.dashboard.wishes');
    Route::get('dashboard/wishes/byMonth', 'WishesController@byMonth')->name('admin.dashboard.wishes.byMonth');
    Route::get('dashboard/events/perMonth', 'OffersController@perMonth')->name('admin.dashboard.events.perMonth');
    Route::get('dashboard/events/perDay', 'OffersController@perDay')->name('admin.dashboard.events.perDay');
    Route::get('dashboard/events/mobileMonth', 'OffersController@mobileMonth')->name('admin.dashboard.events.mobileMonth');
    Route::get('dashboard/events/responseMonth', 'OffersController@responseMonth')->name('admin.dashboard.events.responseMonth');
    Route::get('dashboard/events/responsemMonth', 'OffersController@responsemMonth')->name('admin.dashboard.events.responsemMonth');
    Route::get('dashboard/wishes/byDay', 'WishesController@byDay')->name('admin.dashboard.wishes.byDay');
    Route::get('dashboard/sellers', 'SellersController@index')->name('admin.dashboard.sellers');
    Route::get('dashboard/groups', 'GroupsController@index')->name('admin.dashboard.groups');
    Route::get('dashboard/timeByMonth', 'ReactionController@timeByMonth')->name('admin.dashboard.timeByMonth');
    Route::get('dashboard/timeByDay', 'ReactionController@timeByDay')->name('admin.dashboard.timeByDay');
});
