<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Services\Flag\Src\Flag;

Route::group(['namespace' => 'Api\V1', 'prefix' => 'v1', 'as' => 'v1.'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
        Route::post('login/email', 'AuthController@sendLoginEmail');
        Route::post('login/token/{token}', 'AuthController@token');
        Route::post('login/wish-token/{token}', 'AuthController@wishToken');
        Route::post('login/wishlist-token/{token}', 'AuthController@wishListToken');
    });

    Route::group(['prefix' => 'account'], function () {
        Route::post('sendResetLinkEmail', 'AccountController@sendResetLinkEmail');
    });

    Route::group(['middleware' => ['jwt.verify'], 'prefix' => 'auth'], function () {
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');

        // Password Reset Routes
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
        Route::post('password/reset', 'ResetPasswordController@reset')->name('password.reset');
        Route::post('me', 'AuthController@me');
        Route::post('check/role', 'AuthController@ckeckRole');
    });

    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::get('wishes', 'WishesController@getWishes');
        Route::get('wishlist', 'WishesController@wishlist');
        Route::post('wishes/changeWishStatus', 'WishesController@changeWishStatus');
        Route::get('wishes/{id}', 'WishesController@getWish');
        Route::post('wishes/note/update', 'WishesController@updateNote');

        Route::group(['prefix' => 'agents'], function () {
            Route::get('', 'AgentsController@listAgents');
            Route::get('{id}', 'AgentsController@getAgent');
            Route::put('update/{id}', 'AgentsController@update');
            Route::post('create', 'AgentsController@create');
            Route::delete('delete/{id}', 'AgentsController@delete');
        });

        Route::group(['prefix' => 'account'], function () {
            Route::put('update/{id}', 'AccountController@update');
        });

        Route::group(['middleware' => ['jwt.verify'], 'prefix' => 'account'], function () {
            Route::put('changePassword', 'AccountController@changePassword');
            Route::put('resetPassword', 'AccountController@resetPassword');
        });

        Route::group(['prefix' => 'offers'], function () {
            Route::get('', 'OffersController@index');
            Route::post('/store', 'OffersController@store');
        });

        // autooffers
        Route::group(['prefix' => 'offer'], function () {
            Route::get('list/{wishId}', 'AutooffersController@list');
            //Route::get('ttlist/{wishId}', 'AutooffersController@listTt');
        });

        Route::group(['prefix' => 'messages'], function () {
            Route::get('/{wishId}/{groupId}', 'MessagesController@list');
            Route::post('/', 'MessagesController@create');
            Route::put('/{id}', 'MessagesController@update');
            Route::delete('/{id}', 'MessagesController@delete');
        });

        Route::group(['prefix' => 'contact'], function () {
            Route::post('store', 'ContactController@store');
            Route::post('storeCallback', 'ContactController@storeCallback');
        });
    });

    Route::group(['middleware' => []], function () {
        Route::post('translations', 'TranslationsController@getTranslations');

        Route::post('whitelabels', 'WhitelabelsController@store');
        Route::get('whitelabel/{id}', 'WhitelabelController@getWhitelabelBySlug');
        Route::get('whitelabelfromhost/{host}', 'WhitelabelController@getWhitelabelByHost');
        Route::get('tnb', 'WhitelabelController@getTnb');

        Route::get('wish/store', 'WishesController@store');

        Route::get('destinations', 'RegionsController@getAllDestinations');
        Route::get('airports', 'RegionsController@getAllTTAirports');
        Route::group(['prefix' => 'offer'], function () {
            Route::get('ttlist/{wishId}', 'AutooffersController@listTt');
        });
    });
});
