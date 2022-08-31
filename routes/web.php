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

Route::get('/', 'VueCrudDataController@index');
Route::post('/', 'VueCrudDataController@store');
Route::put('/{id}', 'VueCrudDataController@update');
Route::delete('/{id}', 'VueCrudDataController@destroy');

Route::get('init', 'VueCrudDataController@init');