<?php

/*
 * Wishes Management
 */
Route::group(['namespace' => 'Wishes'], function () {
    Route::resource('wishes', 'WishesController', ['except' => ['show']]);

    //For DataTables
    Route::post('wishes/get', 'WishesTableController')
       ->name('wishes.get');
});
