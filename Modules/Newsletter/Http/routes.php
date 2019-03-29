<?php

Route::group(['middleware' => 'web', 'prefix' => 'newsletter', 'namespace' => 'Modules\Newsletter\Http\Controllers'], function () {
    Route::get('/', 'NewsletterController@index');
    Route::post('store', 'NewsletterController@store')->name('newsletter.store');
});
