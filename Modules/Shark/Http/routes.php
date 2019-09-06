<?php

Route::group(['middleware' => 'web', 'prefix' => 'shark', 'namespace' => 'Modules\Shark\Http\Controllers'], function()
{
    Route::get('/', 'SharkController@index');
});
