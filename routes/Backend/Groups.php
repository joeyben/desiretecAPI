<?php

/*
 * Wishes Management
 */
Route::group(['namespace' => 'Groups'], function () {

    //For DataTables
    Route::post('groups/get', 'GroupsTableController')
       ->name('groups.get');
});
