<?php

Route::group(['middleware' => ['web', 'auth', 'admin'], 'prefix' => 'provider', 'namespace' => 'Modules\LanguageLines\Http\Controllers'], function () {
    Route::get('language-lines', 'LanguageLinesController@index')->name('provider.language-lines');
    Route::get('language-lines/view', 'LanguageLinesController@view')->name('provider.language-lines.view');
    Route::put('language-lines', 'LanguageLinesController@store')->name('provider.language-lines.store');
    Route::get('language-lines/{id}', 'LanguageLinesController@show')->name('provider.language-lines.show')->where('id', '[0-9]+');
    Route::get('language-lines/{id}/edit', 'LanguageLinesController@edit')->name('provider.language-lines.edit')->where('id', '[0-9]+');
    Route::get('language-lines/create', 'LanguageLinesController@create')->name('provider.language-lines.create');
    Route::put('language-lines/{id}', 'LanguageLinesController@update')->name('provider.language-lines.update')->where('id', '[0-9]+');
    Route::delete('language-lines/{id}', 'LanguageLinesController@destroy')->name('provider.language-lines.destroy')->where('id', '[0-9]+');
    Route::delete('language-lines/{id}/destroy', 'LanguageLinesController@forceDelete')
        ->name('provider.language-lines.forceDelete')->where('id', '[0-9]+');
    Route::put('language-lines/{id}/restore', 'LanguageLinesController@restore')->name('provider.language-lines.restore')->where('id', '[0-9]+');
    Route::get('language-lines/export', 'LanguageLinesController@export')->name('provider.language-lines.export');
    Route::post('language-lines/import', 'LanguageLinesController@import')->name('provider.language-lines.import');
    Route::put('language-lines/copy', 'LanguageLinesController@copy')->name('provider.language-lines.copy');
    Route::put('language-lines/clone', 'LanguageLinesController@clone')->name('provider.language-lines.clone');
    Route::get('language-lines/cacheClear', 'LanguageLinesController@cacheClear')->name('provider.language-lines.cacheClear');

    Route::get('languages/email/signature/{lang}', 'LanguageLinesController@signature')->name('provider.email.signature');
    Route::post('languages/email/signature/store', 'LanguageLinesController@signatureStore')->name('provider.email.signature.store');

    Route::get('languages/footer/tnb/{lang}', 'TnbController@tnb')->name('provider.footer.tnb');
    Route::post('languages/footer/tnb/store', 'TnbController@tnbStore')->name('provider.footer.tnb.store');
});
