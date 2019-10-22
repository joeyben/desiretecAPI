<?php
$domain_env = array(
    'local_url' => 'strand.com',
    'development_url' => 'strand.reise-wunsch.com',
    'production_url' => 'strand.reisewunschservice.de',
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('strand.id'));
    setTranslationLoaderModel(\Config::get('strand.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Strand\Http\Controllers', 'as' => 'strand.'], function () {
        Route::get('/', 'StrandController@index');
        Route::get('show', 'StrandController@show');
        Route::get('store', 'StrandController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'StrandWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'StrandWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'StrandWishesController@validateTokenList');
    });
});

