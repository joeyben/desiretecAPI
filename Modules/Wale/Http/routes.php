<?php

Route::group(['middleware' => 'web', 'prefix' => 'wale', 'namespace' => 'Modules\Wale\Http\Controllers'], function()
{
    Route::get('/', 'WaleController@index');
});
