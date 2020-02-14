<?php

Route::group(['middleware' => 'web', 'prefix' => 'step', 'namespace' => 'Modules\Step\Http\Controllers'], function () {
    Route::get('/', 'StepController@index');
});

Route::group(['middleware' => ['web', 'auth', 'admin'], 'prefix' => 'admin', 'namespace' => 'Modules\Step\Http\Controllers'], function () {
    Route::get('step/{id}', 'StepController@step')->name('admin.step');
});
