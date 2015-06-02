<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'ApiDocsController@dashboard');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


Route::get('api/list', 'ApiDocsController@getAll');
Route::get('api/category/{id}', 'ApiDocsController@getByCategory');
Route::get('api/{id}', 'ApiDocsController@getById')->where('id', '[0-9]+');

Route::get('api/add', 'ApiDocsController@add');
Route::post('api/insert', 'ApiDocsController@insert');


Route::get('api/edit/{id}', 'ApiDocsController@edit')->where('id', '[0-9]+');
Route::post('api/update', 'ApiDocsController@update');


Route::get('api/run/{id}', 'ApiDocsController@run');
Route::get('api/dashboard', 'ApiDocsController@dashboard');



Route::get('lookups/list', 'LookupsController@getAll');
Route::get('lookups/add/{asset_type}', 'LookupsController@add');
Route::post('lookups/insert', 'LookupsController@insert');


