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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/extract', 'TMDBController@extract')->name('extract')->middleware(['auth']);
Route::get('/today', 'TMDBController@today')->name('released-today')->middleware(['auth']);
Route::get('/details/{id}', 'TMDBController@details')->name('movie-details')->middleware(['auth']);

Route::get('/home', 'HomeController@index')->name('home');
