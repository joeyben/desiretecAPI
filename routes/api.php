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
    });

    Route::group(['middleware' => ['jwt.verify'], 'prefix' => 'auth'], function () {
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');

        // Password Reset Routes
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
        Route::post('password/reset', 'ResetPasswordController@reset')->name('password.reset');
        Route::post('me', 'AuthController@me');
    });

    Route::group(['prefix' => 'popup'], function () {
        Route::get('show', 'WishesController@show');
    });

    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::get('wishes', 'WishesController@getWishes');
        Route::get('wish/{wish}', 'WishesController@getWish');

        Route::get('agents', 'AgentsController@getAgents');
    });
});
