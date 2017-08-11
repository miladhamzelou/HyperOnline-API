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

Route::auth();

Route::get('/', 'v1_web\UserController@index')->name('home');
Route::get('/home', 'v1_web\UserController@index')->name('home');

Route::get('/profile', 'v1_web\UserController@profile')->name('profile');
Route::get('/admin', 'v1_web\UserController@admin')->name('admin');