<?php

Route::group(['domain' => 'test.com'], function () {
    setCurrentWhiteLabelId(\Config::get('test.id'));
    setTranslationLoaderModel(\Config::get('test.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Test\Http\Controllers' , 'as' => 'test.'], function () {
        Route::get('/', 'TestController@index');
        Route::get('show', 'TestController@show');
        Route::get('store', 'TestController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'TestWishesController@details')->name('wish.details');

    });
});
