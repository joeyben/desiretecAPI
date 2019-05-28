<?php

Route::group(['middleware' => 'web', 'prefix' => 'backups', 'namespace' => 'Modules\Backups\Http\Controllers'], function()
{
    Route::get('/', 'BackupsController@index');
});
