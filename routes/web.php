<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::post('/vocabularies', 'VocabulariesController@create');






Route::get('/{any}', 'HomeController@index')->where('any', '.*');
