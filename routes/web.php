<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::post('/vocabularies', 'VocabulariesController@create');
Route::post('/vocabularies/{id}/edit', 'VocabulariesController@update');
Route::delete('/vocabularies/{id}/delete', 'VocabulariesController@destroy');

Route::get('users/{id}', 'UserProfileController@show');
Route::post('users/edit/{id}', 'UserProfileController@edit');





Route::get('/{any}', 'HomeController@index')->where('any', '.*');
