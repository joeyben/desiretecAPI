<?php

Route::group(['middleware' => 'web', 'prefix' => 'attachments', 'namespace' => 'Modules\Attachments\Http\Controllers'], function () {
    Route::get('/', 'AttachmentsController@index');
});
