<?php

/*
 * Distributions Management
 */
Route::group(['namespace' => 'Distributions'], function () {
    Route::resource('distributions', 'DistributionsController', ['except' => ['show']]);

    //For DataTables
    Route::post('distributions/get', 'DistributionsTableController')
       ->name('distributions.get');
});
