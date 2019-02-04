<?php

Route::group(['middleware' => ['web', 'auth', 'admin', 'access.routeNeedsRole:Administrator'], 'prefix' => 'admin', 'namespace' => 'Modules\Components\Http\Controllers'], function () {
    Route::get('components', 'ComponentsController@index')->name('admin.components');
    Route::get('components/view', 'ComponentsController@view')->name('admin.components.view');
    Route::get('components/uninstall/{key}/{keep}', 'ComponentsController@uninstall')->name('admin.components.uninstall')->where('keep', '[0-1]+');
    Route::get('components/install/{key}', 'ComponentsController@install')->name('admin.components.install')->where('key', '[a-zA-Z]+');
    Route::get('components/seed/{key}', 'ComponentsController@seed')->name('admin.components.seed')->where('key', '[a-zA-Z]+');
    Route::get('components/migrate/{key}', 'ComponentsController@migrate')->name('admin.components.migrate')->where('key', '[a-zA-Z]+');
    Route::get('components/refresh/{key}', 'ComponentsController@refresh')->name('admin.components.refresh')->where('key', '[a-zA-Z]+');
    Route::get('components/rollback/{key}', 'ComponentsController@rollback')->name('admin.components.rollback')->where('key', '[a-zA-Z]+');
});
