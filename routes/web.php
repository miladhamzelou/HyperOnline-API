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
    Route::get('/admin', 'v1_web\AdminController@admin')->name('admin');
    Route::get('/admin/settings', 'v1_web\AdminController@settings')->name('setting');

    Route::get('/admin/products/create', 'v1_web\ProductController@show')->name('product_create');
    Route::post('/admin/products/create', 'v1_web\ProductController@store')->name('product_create');
    Route::get('/admin/products', 'v1_web\ProductController@index')->name('products');
    Route::get('/admin/products/{id}', 'v1_web\ProductController@edit')->name('product_edit');
    Route::post('/admin/products/update', 'v1_web\ProductController@update')->name('product_update');
    Route::get('/admin/products/delete/{id}', 'v1_web\ProductController@delete')->name('product_delete');

    Route::get('/admin/categories/create/{level}', 'v1_web\CategoryController@show')->name('category_create');
    Route::post('/admin/categories/create/{level}', 'v1_web\CategoryController@store')->name('category_create');
    Route::get('/admin/categories', 'v1_web\CategoryController@index')->name('categories');
    Route::get('/admin/categories/{level}/{id}', 'v1_web\CategoryController@edit')->name('category_edit');
    Route::post('/admin/categories/update/{level}', 'v1_web\CategoryController@update')->name('category_update');
    Route::get('/admin/categories/delete/{level}/{id}', 'v1_web\CategoryController@delete')->name('category_delete');

    Route::get('/admin/authors/create', 'v1_web\AuthorController@show')->name('author_create');
    Route::post('/admin/authors/create', 'v1_web\AuthorController@store')->name('author_create');
    Route::get('/admin/authors', 'v1_web\AuthorController@index')->name('authors');
    Route::get('/admin/authors/{id}', 'v1_web\AuthorController@edit')->name('author_edit');
    Route::post('/admin/authors/update', 'v1_web\AuthorController@update')->name('author_update');
    Route::get('/admin/authors/delete/{id}', 'v1_web\AuthorController@delete')->name('author_delete');

    Route::get('/admin/sellers/create', 'v1_web\SellerController@show')->name('seller_create');
    Route::post('/admin/sellers/create', 'v1_web\SellerController@store')->name('seller_create');
    Route::get('/admin/sellers', 'v1_web\SellerController@index')->name('sellers');
    Route::get('/admin/sellers/{id}', 'v1_web\SellerController@edit')->name('seller_edit');
    Route::post('/admin/sellers/update', 'v1_web\SellerController@update')->name('seller_update');
    Route::get('/admin/sellers/delete/{id}', 'v1_web\SellerController@delete')->name('seller_delete');

    Route::get('/admin/users/create', 'v1_web\UserController@show')->name('user_create');
    Route::post('/admin/users/create', 'v1_web\UserController@store')->name('user_create');
    Route::get('/admin/users', 'v1_web\UserController@index')->name('users');
    Route::get('/admin/users/{id}', 'v1_web\UserController@edit')->name('user_edit');
    Route::post('/admin/users/update', 'v1_web\UserController@update')->name('user_update');
    Route::get('/admin/users/delete/{id}', 'v1_web\UserController@delete')->name('user_delete');

    Route::get('/admin/orders/create', 'v1_web\OrderController@show')->name('order_create');
    Route::post('/admin/orders/create', 'v1_web\OrderController@store')->name('order_create');
    Route::get('/admin/orders', 'v1_web\OrderController@index')->name('orders');
    Route::get('/admin/orders/{id}', 'v1_web\OrderController@edit')->name('order_edit');
    Route::post('/admin/orders/update', 'v1_web\OrderController@update')->name('order_update');
    Route::get('/admin/orders/delete/{id}', 'v1_web\OrderController@delete')->name('order_delete');
});
