<?php

Auth::routes();
Route::post('/admin/vocabularies/{id}/edit', 'vocabulariesController@update');


Route::post('/vocabularies', 'VocabulariesController@create');
Route::post('/vocabularies/practice', 'VocabulariesController@practice');
Route::post('/vocabularies/{id}/edit', 'VocabulariesController@update');
Route::delete('/vocabularies', 'VocabulariesController@destroy');

Route::post('/users/update/{id}', 'UserProfileController@update');
Route::get('/users/{id}', 'UserProfileController@show');

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
Route::get('/c/training_plans/{id}', 'TrainingPlanController@show');

Route::get('/c/suggest-images/', 'SuggestImageController@index');
Route::get('/c/suggest-images/{q}', 'SuggestImageController@search');
Route::get('/c/history-scores', 'HistoryScoreController@show');

Route::group(['prefix' => 'admin'], function () {
    Route::post('/users/create', 'UserController@create');
    Route::post('/users/update/{id}', 'UserController@update');
    Route::delete('/users/{id}', 'UserController@destroy');

    Route::post('/structure-grammars/{id}/new', 'StructureSentencesController@create');
    Route::post('/structure-sentences/update/{id}', 'StructureSentencesController@update');
    Route::get('/structure-sentences', 'StructureSentencesController@indexAdmin');
    Route::delete('/structure-sentences/{id}', 'StructureSentencesController@destroy');

    Route::get('/category-structure-grammars/index', 'CategoriesStructureSentencesController@index');
    Route::post('/category-structure-grammars/{id}/new', 'CategoriesStructureSentencesController@create');
    Route::post('/category-structure-grammars/{id}/edit', 'CategoriesStructureSentencesController@edit');
    Route::delete('/category-structure-grammars/{id}', 'CategoriesStructureSentencesController@destroy');
    Route::get('/category-structure-grammars', 'CategoriesStructureSentencesController@index');
    Route::get('/', 'AdminController@index');
});


Route::get('/test', 'GuestController@test');
Route::get('/admin/{any}', 'AdminController@index')->where('any', '.*');
Route::get('/{any}', 'HomeController@index')->where('any', '.*');
