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

//Route::get('/', 'v1_web\AdminController@index')->name('root');
Route::get('/', 'v1\market\MainController@index')->name('root');
Route::get('/home', 'v1\market\MainController@index')->name('home');

Route::get('/profile', 'v1_web\UserController@profile')->name('profile');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/admin', 'v1_web\AdminController@admin')->name('admin');
    Route::get('/admin/database', 'v1_web\AdminController@database_get')->name('database');
    Route::post('/admin/database', 'v1_web\AdminController@database_store')->name('database');
    Route::get('/admin/support', 'v1_web\AdminController@support')->name('support');
    Route::post('/admin/support', 'v1_web\AdminController@support_send')->name('support');

    Route::get('/admin/setting', 'v1_web\AdminController@setting')->name('setting');
    Route::post('/admin/setting', 'v1_web\AdminController@setting_send')->name('setting');
    Route::get('/admin/setting/delete_log', 'v1_web\AdminController@delete_log')->name('setting');

    Route::get('/admin/products/create', 'v1_web\ProductController@show')->name('product_create');
    Route::post('/admin/products/create', 'v1_web\ProductController@store')->name('product_create');
    Route::get('/admin/products', 'v1_web\ProductController@index')->name('products');
    Route::get('/admin/products/{id}', 'v1_web\ProductController@edit')->name('product_edit');
    Route::post('/admin/products/update', 'v1_web\ProductController@update')->name('product_update');
    Route::get('/admin/products/delete/{id}', 'v1_web\ProductController@delete')->name('product_delete');
    Route::get('/admin/products/delete_photo/{id}', 'v1_web\ProductController@delete_photo')->name('product_delete');
    Route::get('/admin/products_inactive', 'v1_web\ProductController@inactive')->name('products_inactive');
    Route::get('/admin/products_active', 'v1_web\ProductController@active')->name('products_active');

    Route::get('/admin/categories/create/{level}', 'v1_web\CategoryController@show')->name('category_create');
    Route::post('/admin/categories/create/{level}', 'v1_web\CategoryController@store')->name('category_create');
    Route::get('/admin/categories', 'v1_web\CategoryController@index')->name('categories');
    Route::get('/admin/categories/{level}/{id}', 'v1_web\CategoryController@edit')->name('category_edit');
    Route::post('/admin/categories/update/{level}', 'v1_web\CategoryController@update')->name('category_update');
    Route::get('/admin/categories/delete/{level}/{id}', 'v1_web\CategoryController@delete')->name('category_delete');
    Route::get('/admin/categories/delete_photo/{level}/{id}', 'v1_web\CategoryController@delete_photo')->name('category_delete');

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
    Route::get('/admin/users/{id}', 'v1_web\UserController@info')->name('user_edit');
    Route::post('/admin/users/update', 'v1_web\UserController@update')->name('user_update');
    Route::get('/admin/users/delete/{id}', 'v1_web\UserController@delete')->name('user_delete');

    Route::get('/admin/orders/create', 'v1_web\OrderController@show')->name('order_create');
    Route::post('/admin/orders/create', 'v1_web\OrderController@store')->name('order_create');
    Route::get('/admin/orders', 'v1_web\OrderController@index')->name('orders');
    Route::get('/admin/orders/{id}', 'v1_web\OrderController@details')->name('order_details');
    Route::post('/admin/orders/update', 'v1_web\OrderController@update')->name('order_update');
    Route::get('/admin/orders/delete/{id}', 'v1_web\OrderController@delete')->name('order_delete');

    Route::get('/admin/pays', 'v1_web\OrderController@pays')->name('pays');

    Route::get('/admin/messages', 'v1_web\AdminController@messages')->name('messages');
    Route::get('/admin/messages/sms', 'v1_web\AdminController@messages_sms')->name('messages');
    Route::get('/admin/messages/push', 'v1_web\AdminController@messages_push')->name('messages');
    Route::post('/admin/messages/sms', 'v1_web\AdminController@messages_send_sms')->name('messages');
    Route::post('/admin/messages/push', 'v1_web\AdminController@messages_send_push')->name('messages');

    Route::post('/admin/confirm/message', 'v1_web\AdminController@messages_send_confirm')->name('messages');
    Route::get('/admin/confirm/{id}/{code}', 'v1_web\AdminController@confirmInfo')->name('confirm');

    Route::get('/admin/accounting', 'v1_web\AdminController@accounting')->name('accounting');

    Route::get('/admin/banners/create', 'v1_web\AdminController@banner_show')->name('banner_show');
    Route::post('/admin/banners/create', 'v1_web\AdminController@banner_create')->name('banner_create');
    Route::get('/admin/banners', 'v1_web\AdminController@banners')->name('banners');
    Route::get('/admin/banners/{id}', 'v1_web\AdminController@banner_edit')->name('banner_edit');
    Route::post('/admin/banners/update', 'v1_web\AdminController@banner_update')->name('banner_update');
    Route::get('/admin/banners/delete/{id}', 'v1_web\AdminController@banner_delete')->name('banner_delete');
});

Route::get('/search', 'v1_web\AdminController@search');
Route::get('/admin/search', 'v1_web\AdminController@search');

Route::get('category/{level}/{id}', 'v1\market\CategoryController@index');
Route::get('/addToCart', 'v1\ProductController@addToCart');
Route::get('/removeFromCart', 'v1\ProductController@removeFromCart');
Route::get('/checkout', 'v1\market\MainController@checkout')->name('checkout');
Route::get('/pay', 'v1\market\MainController@pay')->name('pay');
Route::post('/callback', 'v1\market\MainController@callback');
Route::get('/admin/downloadFactor/{id}', 'v1_web\OrderController@downloadFactor');