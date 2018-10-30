<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::post('/vocabularies', 'VocabulariesController@create');

Route::post('/vocabularies/{id}/edit', 'VocabulariesController@update');
Route::delete('/vocabularies/{id}/delete', 'VocabulariesController@destroy');
Route::get('users/{id}', 'UserProfileController@show');
Route::post('users/edit/{id}', 'UserProfileController@edit');

Route::get('/grammars/{id}', 'GrammarsController@show');
Route::post('/grammars/create', 'GrammarsController@create');
Route::get('/grammars-articles', 'GrammarArticleController@index');

Route::get('/redirect/{social}', 'SocialAuthController@redirect');
Route::get('/callback/{social}', 'SocialAuthController@callback');



Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'AdminController@index');
});

Route::get('/admin/{any}', 'AdminController@index')->where('any', '.*');
Route::get('/{any}', 'HomeController@index')->where('any', '.*');

