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
Route::group(['middleware' => ['web', 'auth', 'verified', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'], 'prefix' => LaravelLocalization::setLocale() . '/admin'], function () {
    Route::get('activities', 'ActivitiesController@index')->name('admin.activities');
    Route::get('activities/view', 'ActivitiesController@view')->name('admin.activities.view');
});

Route::group(['middleware' => ['web'], 'prefix' => '/admin'], function () {
    Route::get('activities/{id}', 'ActivitiesController@show')->name('admin.activities.show')->where('id', '[0-9]+');
});
