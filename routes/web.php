<?php

Auth::routes();

Route::post('/vocabularies', 'VocabulariesController@create');

Route::post('/vocabularies/{id}/edit', 'VocabulariesController@update');
Route::delete('/vocabularies/{id}/delete', 'VocabulariesController@destroy');
Route::post('users/update/{id}', 'UserProfileController@update');
Route::get('users/{id}', 'UserProfileController@show');

Route::get('/ngu-phap-tieng-anh', 'StructureSentencesController@index');
Route::post('/grammars/create', 'UserGrammarsController@create');
Route::post('/grammars/update/{id}', 'UserGrammarsController@update');
Route::delete('/grammars/{id}', 'UserGrammarsController@destroy');
Route::get('/grammars/{id}', 'UserGrammarsController@show');

Route::get('/redirect/{social}', 'SocialAuthController@redirect');
Route::get('/callback/{social}', 'SocialAuthController@callback');

Route::post('/password/reset');
Route::post('/setting/plan', 'UserProfileController@edit_target_score');

Route::post('/setting/reminder', 'TrainingPlanController@create');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'AdminController@index');
});

Route::get('/admin/{any}', 'AdminController@index')->where('any', '.*');
Route::get('/{any}', 'HomeController@index')->where('any', '.*');
