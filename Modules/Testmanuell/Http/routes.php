<?php
$domain_env = array(
    'local_url' => 'testmanuell.com',
    'development_url' => 'testmanuell.reise-wunsch.com',
    'production_url' => 'testmanuell.reisewunschservice.de',
);

$domain = $domain_env[\Config::get('app.js_env') . '_url'];

Route::group(['domain' => $domain], function () {
    setCurrentWhiteLabelId(\Config::get('testmanuell.id'));
    setTranslationLoaderModel(\Config::get('testmanuell.language_lines_model'));
    Route::group(['middleware' => 'web', 'namespace' => 'Modules\Testmanuell\Http\Controllers', 'as' => 'testmanuell.'], function () {
        Route::get('/', 'TestmanuellController@index');
        Route::get('show', 'TestmanuellController@show');
        Route::get('store', 'TestmanuellController@store')->name('store');
        Route::get('wish/{wish}/{token}', 'TestmanuellWishesController@details')->name('wish.details');
        Route::get('getwish/{wish}', 'TestmanuellWishesController@getWish')->name('getWish');
        Route::get('wishlist/{token}', 'TestmanuellWishesController@validateTokenList');
    });
});

