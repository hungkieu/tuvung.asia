<?php

Auth::routes();

Route::post('/vocabularies', 'VocabulariesController@create');
Route::post('/vocabularies/practice', 'VocabulariesController@practice');
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
    Route::post('/structure-sentences/update/{id}', 'StructureSentencesController@update');
    Route::get('/structure-sentences', 'StructureSentencesController@indexAdmin');
    Route::delete('/structure-sentences', 'StructureSentencesController@destroy');
    Route::post('/structure-grammars/{id}/new', 'StructureSentencesController@create');
    Route::post('/category-structure-grammars/{id}/new', 'CategoriesStructureSentencesController@create');
    Route::get('/category-structure-grammars', 'CategoriesStructureSentencesController@index');
    Route::get('/', 'AdminController@index');
});


Route::get('search/{en}', function ($en) {
    include(app_path() . '\Http\HtmlDomParser.php');
    // if($en == 'all')
    //     return Vocabulary::where('image', '!=', null)->get();
    // return Vocabulary::where('en', 'like', '%'.$en.'%')->where('image', '!=', null)->limit(10)->get();
    $url = 'https://www.bing.com/images/search?q='.$en;
    $html = file_get_html($url);
    foreach ($html->find('img') as $element) {
        echo '<img src="'.$element->src.'" /><br>';
    }
});


Route::get('/admin/{any}', 'AdminController@index')->where('any', '.*');
Route::get('/{any}', 'HomeController@index')->where('any', '.*');
