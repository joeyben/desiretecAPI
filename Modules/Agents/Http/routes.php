<?php

Route::group(['middleware' => 'web', 'prefix' => 'agents', 'namespace' => 'Modules\Agents\Http\Controllers'], function () {
    Route::get('/', 'AgentsController@index');
});
