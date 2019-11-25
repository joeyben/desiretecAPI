<?php

Route::group(['middleware' => 'web', 'prefix' => 'ben', 'namespace' => 'Modules\Ben\Http\Controllers'], function () {
    Route::get('/', 'BenController@index');
});
