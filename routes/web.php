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

Route::post('/SendCreationFIO', 'MainController@SendCreationFIO', 'SendCreationFIO');

Route::get('/SubjectCreation', 'MainController@SubjectCreation');
Route::post('/SubjectCreation/check', 'MainController@SubjectCreation_check');
Route::get('/BindingStudent', 'MainController@BindingStudent');

Route::post('/BindingStudToSubj', 'MainController@BindingStudToSubj', 'BindingStudToSubj');

Route::get('/ShowStudents', 'MainController@ShowStudents');

Route::post('/ShowTable', 'MainController@ShowTable','ShowTable');

Route::get('/GradingStudent', 'MainController@GradingStudent');
Route::post('/GradingStudent/check', 'MainController@GradingStudent_check');
Route::post('/GradingStud', 'MainController@GradingStud','GradingStud');

Route::get('/DeleteStudent', 'MainController@DeleteStudent');
Route::post('/DeleteStudent/check', 'MainController@DeleteStudent_check');

Route::post('/SendDeleteID', 'MainController@SendDeleteID', 'SendDeleteID');

Route::get('/DeleteSubject', 'MainController@DeleteSubject');
Route::post('/DeleteSubject/check', 'MainController@DeleteSubject_check');


Route::get('/GetTableSubjects', 'MainController@GetTableSubjects','GetTableSubjects');

Route::post('/DeleteString', 'MainController@DeleteString','DeleteString');
Route::post('/ChangeString', 'MainController@ChangeString','ChangeString');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
