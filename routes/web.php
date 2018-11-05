<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::post('/vocabularies', 'VocabulariesController@create');

Route::post('/vocabularies/{id}/edit', 'VocabulariesController@update');
Route::delete('/vocabularies/{id}/delete', 'VocabulariesController@destroy');
Route::post('users/update/{id}', 'UserProfileController@update');
Route::get('users/{id}', 'UserProfileController@show');

Route::get('/ngu-phap-tieng-anh', 'GrammarArticleController@index');
Route::post('/grammars/create', 'GrammarsController@create');
Route::post('/grammars/update/{id}', 'GrammarsController@update');
Route::delete('/grammars/{id}', 'GrammarsController@destroy');
Route::get('/grammars/{id}', 'GrammarsController@show');

Route::get('/redirect/{social}', 'SocialAuthController@redirect');
Route::get('/callback/{social}', 'SocialAuthController@callback');

Route::post('/password/reset');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'AdminController@index');
});

Route::get('/admin/{any}', 'AdminController@index')->where('any', '.*');
Route::get('/{any}', 'HomeController@index')->where('any', '.*');
