<?php

Route::group(['middleware' => 'web', 'prefix' => 'soul', 'namespace' => 'Modules\Soul\Http\Controllers'], function()
{
    Route::get('/', 'SoulController@index');
});
