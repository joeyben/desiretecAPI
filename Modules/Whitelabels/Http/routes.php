<?php

Route::group(['middleware' => 'web', 'prefix' => 'whitelabels', 'namespace' => 'Modules\Whitelabels\Http\Controllers'], function()
{
    Route::get('/', 'WhitelabelsController@index');
});
