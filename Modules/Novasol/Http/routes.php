<?php

Route::group(['domain' => 'novasol.org'], function () {
    setCurrentWhiteLabelId(\Config::get('novasol.id'));
    setTranslationLoaderModel(\Config::get('novasol.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Novasol\Http\Controllers' , 'as' => 'novasol.'], function () {
        Route::get('/', 'NovasolController@index');
        Route::get('show', 'NovasolController@show');
        Route::get('store', 'NovasolController@store')->name('store');
        Route::get('wish/{wish}', 'NovasolWishesController@view')->name('wish.view');
        Route::get('wish/{wish}/{token}', 'NovasolWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'NovasolWishesController@getWish')->name('getWish');
        Route::get('wishlist', 'NovasolWishesController@wishList')->name('list');
    });
});
