<?php
$domain_env = array(
    'local_url' => 'tui.com',
    'development_url' => 'tui.reise-wunsch.com',
    'production_url' => 'tui.reisewunschservice.de',
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('tui.id'));
    setTranslationLoaderModel(\Config::get('tui.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Tui\Http\Controllers', 'as' => 'tui.'], function () {
        Route::get('/', 'TuiController@index');
        Route::get('show', 'TuiController@show');
        Route::get('store', 'TuiController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'TuiWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'TuiWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'TuiWishesController@validateTokenList');
    });
});

