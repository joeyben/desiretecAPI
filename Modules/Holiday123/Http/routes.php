<?php
$domain_env = array(
    'local_url' => 'https://holiday123.com',
    'development_url' => 'https://holiday123.reise-wunsch.com',
    'production_url' => 'https://holiday123.reisewunschservice.de',
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('holiday123.id'));
    setTranslationLoaderModel(\Config::get('holiday123.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Holiday123\Http\Controllers', 'as' => 'holiday123.'], function () {
        Route::get('/', 'Holiday123Controller@index');
        Route::get('show', 'Holiday123Controller@show');
        Route::get('store', 'Holiday123Controller@store')->name('store');
        Route::get('wish/{wish}/{token}', 'Holiday123WishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'Holiday123WishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'Holiday123WishesController@validateTokenList');
        Route::get('tnb', 'Holiday123Controller@getPDF');
    });
});

