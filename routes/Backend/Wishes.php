<?php

/*
 * Wishes Management
 */
Route::group(['namespace' => 'Wishes'], function () {
    //For DataTables
    Route::post('wishes/get', 'WishesTableController')
       ->name('wishes.get');
});
