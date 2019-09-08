<?php

Route::group(['middleware' => 'web', 'prefix' => 'squad', 'namespace' => 'Modules\Squad\Http\Controllers'], function()
{
    Route::get('/', 'SquadController@index');
});
