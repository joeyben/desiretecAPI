<?php

Route::group(['middleware' => 'web', 'prefix' => 'variants', 'namespace' => 'Modules\Variants\Http\Controllers'], function()
{
    Route::get('/', 'VariantsController@index');
});
