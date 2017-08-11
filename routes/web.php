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

Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin', 'v1_web\UserController@admin')->name('admin');

    Route::get('/admin/products/create', 'v1_web\ProductController@show')->name('product_create');
    Route::post('/admin/products/create', 'v1_web\ProductController@store')->name('product_create');
    Route::get('/admin/products', 'v1_web\ProductController@index')->name('products');

    Route::get('/admin/categories/create', 'v1_web\CategoryController@show')->name('category_create');
    Route::post('/admin/categories/create', 'v1_web\CategoryController@store')->name('category_create');
    Route::get('/admin/categories', 'v1_web\CategoryController@index')->name('categories');
});
