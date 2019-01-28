<?php

Route::group(['middleware' => 'web', 'prefix' => 'attachments', 'namespace' => 'Modules\Attachments\Http\Controllers'], function () {
    Route::post('/store', 'AttachmentsController@store')->name('attachments.store');
    Route::delete('/destroy/{id}', 'AttachmentsController@destroy')->name('attachments.destroy')->where('id', '[0-9]+');
});
