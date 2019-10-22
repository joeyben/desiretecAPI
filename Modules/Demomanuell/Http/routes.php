<?php
$domain_env = array(
    'local_url' => 'demomanuell.com',
    'development_url' => 'demomanuell.reise-wunsch.com',
    'production_url' => 'demomanuell.reisewunschservice.de',
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('demomanuell.id'));
    setTranslationLoaderModel(\Config::get('demomanuell.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Demomanuell\Http\Controllers', 'as' => 'demomanuell.'], function () {
        Route::get('/', 'DemomanuellController@index');
        Route::get('show', 'DemomanuellController@show');
        Route::get('store', 'DemomanuellController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'DemomanuellWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'DemomanuellWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'DemomanuellWishesController@validateTokenList');
    });
});

