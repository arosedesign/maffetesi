<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/', 'QuizController@index')->name('index');
Route::post('/salva-risposta', 'QuizController@salvaRisposta')->name('salvaRisposta');
Route::get('/thanks', 'QuizController@thanks')->name('thanks');

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/home/edit-user', 'HomeController@editUser')->name('editUser');
Route::post('/home/edit-tabella', 'HomeController@editTabella')->name('editTabella');
Route::post('/home/delete', 'HomeController@delete')->name('delete');
Route::get('/risultati', 'HomeController@risultati')->name('risultati');
Route::post('/risultati-filtrati', 'HomeController@risultatiFiltrati')->name('risultati-filtrati');


