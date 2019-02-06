<?php

/**
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */

/*Route::domain('localhost:8000')->group(function () {
    Route::get('bla', 'FrontendController@macros')->name('bla');     //
});*/


//Route::group(['domain' => 'localhost'], function () {
    Route::get('/', 'FrontendController@index')->name('index');
    Route::get('macros', 'FrontendController@macros')->name('macros');
//Route::post('/get/states', 'FrontendController@getStates')->name('get.states');
//Route::post('/get/cities', 'FrontendController@getCities')->name('get.cities');

    /*
     * These frontend controllers require the user to be logged in
     * All route names are prefixed with 'frontend.'
     */
    Route::group(['middleware' => 'auth'], function () {
        Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
            /*
             * User Dashboard Specific
             */
            Route::get('dashboard', 'DashboardController@index')->name('dashboard');

            /*
             * User Account Specific
             */
            Route::get('account', 'AccountController@index')->name('account');

            /*
             * User Profile Specific
             */
            Route::patch('profile/update', 'ProfileController@update')->name('profile.update');

            /*
             * User Profile Picture
             */
            Route::patch('profile-picture/update', 'ProfileController@updateProfilePicture')->name('profile-picture.update');
        });
        Route::group(['namespace' => 'Wishes', 'as' => 'wishes.'], function () {
            Route::get('wishlist', 'WishesController@wishList')->name('list');

            Route::get('wishes', 'WishesController@index')->name('index');
            Route::get('wish/{wish}', 'WishesController@show')->name('wish');

            Route::post('wishes/get', 'WishesTableController')->name('get');
            Route::get('wishes/getlist', 'WishesController@getList')->name('getlist');

            Route::get('wishes/create', 'WishesController@create')->name('create');

            Route::get('wish/{wish}/{token}', 'WishesController@validateToken');
            Route::get('wish/{wish}', 'WishesController@show');
            Route::post('wish/store', 'WishesController@store')->name('store');
            Route::get('wish/edit/{wish}', 'WishesController@edit')->name('edit');
            Route::get('wish/destroy', 'WishesController@destroy')->name('destroy');
            Route::patch('wish/update/{wish}', 'WishesController@update')->name('update');

        });

        Route::group(['namespace' => 'Offers', 'as' => 'offers.'], function () {
            Route::get('offers', 'OffersController@index')->name('index');
            Route::post('offers/get', 'OffersTableController')->name('get');
            Route::get('offers/create/{id}', 'OffersController@create')->name('create');
            Route::post('offers/store', 'OffersController@store')->name('store');
            Route::post('offers/edit', 'OffersController@edit')->name('edit');
            Route::post('offers/destroy', 'OffersController@destroy')->name('destroy');

            Route::get('wish/offers/{wish}', 'OffersController@getWishOffers')->name('showoffers');

            Route::post('wish/getoffers', 'OffersTableController@showOffersForWish')->name('wishoffers');

        });

        Route::group(['namespace' => 'Agents', 'as' => 'agents.'], function () {
            Route::get('agents', 'AgentsController@index')->name('index');
            Route::post('agents/get', 'AgentsTableController')->name('get');
            Route::get('agent/profile', 'AgentsController@profile')->name('profile');
            Route::get('agents/create', 'AgentsController@create')->name('create');
            Route::post('agents/store', 'AgentsController@store')->name('store');
            Route::post('agents/edit', 'AgentsController@edit')->name('edit');
            Route::post('agents/destroy', 'AgentsController@destroy')->name('destroy');
            Route::get('agents/status/{id}', 'AgentsController@status')->name('status');
        });

        Route::group(['namespace' => 'Comments', 'as' => 'comments.'], function () {

            Route::get('comments', 'CommentsController@index')->name('index');
            Route::post('comment/store', 'CommentsController@store')->name('store');

        });

        Route::group(['namespace' => 'Messages', 'as' => 'messages.'], function () {
            Route::get('messages/{wish}/{group}', 'MessagesController@getMessages');
            Route::post('messages', 'MessagesController@sendMessage');
            Route::get('message/delete/{message}', 'MessagesController@deleteMessage');
            Route::post('message/edit/{message}/{m}', 'MessagesController@editMessage');

        });

    });

    /*
    * Show pages
    */
    Route::get('pages/{slug}', 'FrontendController@showPage')->name('pages.show');

//});