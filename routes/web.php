<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::post('/vocabularies', 'VocabulariesController@create');


Route::get('users/{id}', 'UserProfileController@show');
Route::post('users/edit/{id}', 'UserProfileController@edit');





Route::get('/{any}', 'HomeController@index')->where('any', '.*');
