<?php

/*
 * Wishes Management
 */
Route::group(['namespace' => 'Whitelabels'], function () {
    Route::resource('whitelabels', 'WhitelabelsController', ['except' => ['show']]);
    Route::get('whitelabels/view', 'WhitelabelsController@view')->name('whitelabels.view');

    //For DataTables
    Route::post('whitelabels/get', 'WhitelabelsTableController')
       ->name('whitelabels.get');
});
