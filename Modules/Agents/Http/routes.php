<?php

Route::group(['middleware' => 'web', 'prefix' => 'agents', 'namespace' => 'Modules\Agents\Http\Controllers'], function () {
    Route::get('/switch/{id}','LoginController@switch')->name('agents.switch');
});
