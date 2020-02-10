<?php

Route::group(['middleware' => 'web', 'prefix' => 'step', 'namespace' => 'Modules\Step\Http\Controllers'], function()
{
    Route::get('/', 'StepController@index');
});
