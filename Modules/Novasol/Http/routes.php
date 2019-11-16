<?php

$domain_env = array(
    'local_url' => 'novasol.org',
    'development_url' => 'novasol.reise-wunsch.com',
    'production_url' => 'novasol.reisewunschservice.de',
    'preproduction_url' => 'novasol.preprod.reisewunschservice.de'
);

$domain = $domain_env[\Config::get('app.js_env'). '_url'];

Route::get('test', function(){


    $client = new GuzzleHttp\Client();
    $res = $client->get('https://de-staging-ttxml.traveltainment.eu/TTXml-1.8/DispatcherWS', [
        'auth' => [
            'MKT_315150_DE', 'G6zP4s=gbNM891e'
        ]
    ]);

    dd($res);

});

Route::group(['domain' => $domain], function () {
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
        Route::get('wishlist/{token}', 'NovasolWishesController@validateTokenList');
        Route::get('/fill-areas-from-novasol-api', 'NovasolController@fillAreasFromNovasolApi');
        Route::get('/fill-countries-from-novasol-api', 'NovasolController@fillCountriesFromNovasolApi');
        Route::get('/product/{id}', 'NovasolController@getProduct');
    });
});
