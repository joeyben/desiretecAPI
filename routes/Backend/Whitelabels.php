<?php

/*
 * Wishes Management
 */
Route::group(['namespace' => 'Whitelabels'], function () {
    Route::resource('whitelabels', 'WhitelabelsController', ['except' => ['show']]);

    //For DataTables
    Route::post('whitelabels/get', 'WhitelabelsTableController')
       ->name('whitelabels.get');
});
