<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'MainController@main');
Route::get('/StudentCreation', 'MainController@StudentCreation');
Route::post('/StudentCreation/check', 'MainController@StudentCreation_check');
Route::get('/SubjectCreation', 'MainController@SubjectCreation');
Route::post('/SubjectCreation/check', 'MainController@SubjectCreation_check');
Route::get('/BindingStudent', 'MainController@BindingStudent');
Route::post('/BindingStudent/check', 'MainController@BindingStudent_check');
Route::get('/ShowStudents', 'MainController@ShowStudents');
Route::post('/ShowStudents/check', 'MainController@ShowStudents_check');
Route::get('/GradingStudent', 'MainController@GradingStudent');
Route::post('/GradingStudent/check', 'MainController@GradingStudent_check');

Route::get('/DeleteStudent', 'MainController@DeleteStudent');
Route::post('/DeleteStudent/check', 'MainController@DeleteStudent_check');
Route::get('/DeleteSubject', 'MainController@DeleteSubject');
Route::post('/DeleteSubject/check', 'MainController@DeleteSubject_check');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
