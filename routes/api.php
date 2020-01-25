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

    Route::group(['prefix' => 'popup'], function () {
        Route::get('show', 'WishesController@show');
    });

    Route::get('offers/{id}', 'OffersController@index');
    Route::post('offers/store', 'OffersController@store');

    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::get('wishes', 'WishesController@getWishes');
        Route::get('wish/{wish}', 'WishesController@getWish');

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
    });
});
