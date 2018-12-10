<?php

Route::group(['middleware' => 'web', 'prefix' => 'groups', 'namespace' => 'Modules\Groups\Http\Controllers'], function () {
    Route::get('/', 'GroupsController@index');
});
