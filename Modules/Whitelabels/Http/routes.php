<?php
Route::group(['middleware' => ['web', 'auth', 'admin'], 'prefix' => 'provider', 'namespace' => 'Modules\Whitelabels\Http\Controllers'], function () {
    Route::get('whitelabels', 'WhitelabelsController@index')->name('admin.whitelabels');
    Route::get('whitelabels/view', 'WhitelabelsController@view')->name('admin.whitelabels.view');
    Route::get('whitelabels/list', 'WhitelabelsController@list')->name('admin.whitelabels.list');
});
