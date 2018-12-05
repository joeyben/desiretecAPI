<?php

Route::group(['middleware' => 'web', 'prefix' => 'nmviajes', 'namespace' => 'Modules\Nmviajes\Http\Controllers'], function () {
    Route::get('/', 'NmviajesController@index');
});
