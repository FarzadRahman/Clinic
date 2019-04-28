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
Route::get('appointment/run/serial', 'AppoinmentController@runSerial')->name('appointment.runSerial');
