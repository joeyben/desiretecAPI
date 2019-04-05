<?php

Route::group(['domain' => 'novasol.reisewunschservice.de'], function () {
    setCurrentWhiteLabelId(\Config::get('novasol.id'));
    setTranslationLoaderModel(\Config::get('novasol.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Novasol\Http\Controllers' , 'as' => 'novasol.'], function () {
        Route::get('/', 'NovasolController@index');
        Route::get('show', 'NovasolController@show');
        Route::get('store', 'NovasolController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'NovasolWishesController@details')->name('wish.details');

    });
});
