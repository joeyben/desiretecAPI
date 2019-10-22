<?php

/*
 * Wishes Management
 */
Route::group(['namespace' => 'Whitelabels'], function () {
    Route::get('whitelabels/view', 'WhitelabelsController@view')->name('whitelabels.view');
    Route::get('whitelabels/compile', 'WhitelabelsController@compile')->name('whitelabels.compile');
    //For DataTables
    Route::post('whitelabels/get', 'WhitelabelsTableController')
       ->name('whitelabels.get');
});
