<?php
$domain_env = array(
    'local_url' => 'kreuzfahrtberatung.com',
    'development_url' => 'kreuzfahrtberatung.reise-wunsch.com',
    'production_url' => 'kreuzfahrtberatung.reisewunschservice.de',
    'preproduction_url' => 'kreuzfahrtberatung.preprod.reisewunschservice.de'
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('kreuzfahrtberatung.id'));
    setTranslationLoaderModel(\Config::get('kreuzfahrtberatung.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Kreuzfahrtberatung\Http\Controllers', 'as' => 'kreuzfahrtberatung.'], function () {
        Route::get('/', 'KreuzfahrtberatungController@index');
        Route::get('show', 'KreuzfahrtberatungController@show');
        Route::get('store', 'KreuzfahrtberatungController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'KreuzfahrtberatungWishesController@details')->name('wish.details');
        Route::get('wish/{wish}', 'KreuzfahrtberatungWishesController@view')->name('wish.view');
        Route::get('getwish/{wish}', 'KreuzfahrtberatungWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'KreuzfahrtberatungWishesController@validateTokenList');
        Route::get('wishlist', 'KreuzfahrtberatungWishesController@wishList')->name('list');
    });
});

