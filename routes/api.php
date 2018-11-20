<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/v1/users', 'Api\V1\UsersController@index');
Route::get('/v1/users/{id}/vocabularies', 'Api\V1\vocabulariesController@index');
Route::get('/v1/users/{id}/vocabularies/dictionary', 'Api\V1\vocabulariesController@dictionary');
Route::get('/v1/users/{id}/vocabularies/count', 'Api\V1\vocabulariesController@count');
Route::get('/v1/vocabularies/{id}', 'Api\V1\vocabulariesController@show');
Route::get('/v1/vocabularies/{id}/pedigree', 'Api\V1\vocabulariesController@pedigree');
Route::get('/v1/vocabularies/search/{en}', 'Api\V1\vocabulariesController@search');
Route::get('/v1/vocabularies', 'Api\V1\vocabulariesController@all');
