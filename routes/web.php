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

//Route::get('/', function () {
//    return view('welcome');
//})->name('welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('welcome');
Route::get('appointment/', 'AppoinmentController@index')->name('appointment.index');
Route::post('appointment/insert', 'AppoinmentController@insert')->name('appointment.insert');
Route::post('appointment/getData', 'AppoinmentController@getData')->name('appointment.getData');
Route::post('appointment/edit', 'AppoinmentController@edit')->name('appointment.edit');
Route::post('appointment/update/{id}', 'AppoinmentController@update')->name('appointment.update');
Route::post('appointment/startInQueue/', 'AppoinmentController@startInQueue')->name('appointment.startInQueue');
Route::post('appointment/cancel/', 'AppoinmentController@cancel')->name('appointment.cancel');


Route::get('appointment/run/serial', 'AppoinmentController@runSerial')->name('appointment.runSerial');
