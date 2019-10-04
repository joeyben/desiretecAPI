<?php
$domain_env = array(
    'local_url' => 'demokreuzfahrtberatung.com',
    'development_url' => 'demokreuzfahrtberatung.reise-wunsch.com',
    'production_url' => 'demokreuzfahrtberatung.reisewunschservice.de',
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('demokreuzfahrtberatung.id'));
    setTranslationLoaderModel(\Config::get('demokreuzfahrtberatung.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Demokreuzfahrtberatung\Http\Controllers', 'as' => 'demokreuzfahrtberatung.'], function () {
        Route::get('/', 'DemokreuzfahrtberatungController@index');
        Route::get('show', 'DemokreuzfahrtberatungController@show');
        Route::get('store', 'DemokreuzfahrtberatungController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'DemokreuzfahrtberatungWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'DemokreuzfahrtberatungWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'DemokreuzfahrtberatungWishesController@validateTokenList');
    });
});

