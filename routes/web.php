<?php

Route::auth();

Route::get('/', 'v1\market\MainController@index')->name('root');
Route::get('/home', 'v1\market\MainController@index')->name('home');

Route::get('/profile', 'v1\ADMIN\UserController@profile')->name('profile');

Route::group(['middleware' => ['auth']], function () {
	Route::get('/admin', 'v1\ADMIN\AdminController@admin')->name('admin');
	Route::get('/admin/database', 'v1\ADMIN\AdminController@database_get')->name('database');
	Route::post('/admin/database', 'v1\ADMIN\AdminController@database_store')->name('database');
	Route::get('/admin/support', 'v1\ADMIN\AdminController@support')->name('support');
	Route::post('/admin/support', 'v1\ADMIN\AdminController@support_send')->name('support');

	Route::get('/admin/setting', 'v1\ADMIN\AdminController@setting')->name('setting');
	Route::post('/admin/setting', 'v1\ADMIN\AdminController@setting_send')->name('setting');
	Route::get('/admin/setting/delete_log', 'v1\ADMIN\AdminController@delete_log')->name('setting');
	Route::get('/admin/setting/resetMostSell', 'v1\ADMIN\AdminController@resetMostSell')->name('setting');
	Route::get('/admin/setting/confirmAllPhones', 'v1\ADMIN\AdminController@confirmAllPhones')->name('setting');
	Route::post('/admin/setting/updateOffline', 'v1\ADMIN\AdminController@updateOffline')->name('setting');

	Route::get('/admin/products/create', 'v1\ADMIN\ProductController@show')->name('product_create');
	Route::post('/admin/products/create', 'v1\ADMIN\ProductController@store')->name('product_create');
	Route::get('/admin/products', 'v1\ADMIN\ProductController@index')->name('products');
	Route::get('/admin/products/{id}', 'v1\ADMIN\ProductController@edit')->name('product_edit');
	Route::post('/admin/products/update', 'v1\ADMIN\ProductController@update')->name('product_update');
	Route::get('/admin/products/delete/{id}', 'v1\ADMIN\ProductController@delete')->name('product_delete');
	Route::get('/admin/products/delete_photo/{id}', 'v1\ADMIN\ProductController@delete_photo')->name('product_delete');
	Route::get('/admin/products_inactive', 'v1\ADMIN\ProductController@inactive')->name('products_inactive');
	Route::get('/admin/products_active', 'v1\ADMIN\ProductController@active')->name('products_active');

	Route::get('/admin/categories/create/{level}', 'v1\ADMIN\CategoryController@show')->name('category_create');
	Route::post('/admin/categories/create/{level}', 'v1\ADMIN\CategoryController@store')->name('category_create');
	Route::get('/admin/categories', 'v1\ADMIN\CategoryController@index')->name('categories');
	Route::get('/admin/categories/{level}/{id}', 'v1\ADMIN\CategoryController@edit')->name('category_edit');
	Route::post('/admin/categories/update/{level}', 'v1\ADMIN\CategoryController@update')->name('category_update');
	Route::get('/admin/categories/delete/{level}/{id}', 'v1\ADMIN\CategoryController@delete')->name('category_delete');
	Route::get('/admin/categories/delete_photo/{level}/{id}', 'v1\ADMIN\CategoryController@delete_photo')->name('category_delete');

	Route::get('/admin/authors/create', 'v1\ADMIN\AuthorController@show')->name('author_create');
	Route::post('/admin/authors/create', 'v1\ADMIN\AuthorController@store')->name('author_create');
	Route::get('/admin/authors', 'v1\ADMIN\AuthorController@index')->name('authors');
	Route::get('/admin/authors/{id}', 'v1\ADMIN\AuthorController@edit')->name('author_edit');
	Route::post('/admin/authors/update', 'v1\ADMIN\AuthorController@update')->name('author_update');
	Route::get('/admin/authors/delete/{id}', 'v1\ADMIN\AuthorController@delete')->name('author_delete');

	Route::get('/admin/sellers/create', 'v1\ADMIN\SellerController@show')->name('seller_create');
	Route::post('/admin/sellers/create', 'v1\ADMIN\SellerController@store')->name('seller_create');
	Route::get('/admin/sellers', 'v1\ADMIN\SellerController@index')->name('sellers');
	Route::get('/admin/sellers/{id}', 'v1\ADMIN\SellerController@edit')->name('seller_edit');
	Route::post('/admin/sellers/update', 'v1\ADMIN\SellerController@update')->name('seller_update');
	Route::get('/admin/sellers/delete/{id}', 'v1\ADMIN\SellerController@delete')->name('seller_delete');

	Route::get('/admin/users/create', 'v1\ADMIN\UserController@show')->name('user_create');
	Route::post('/admin/users/create', 'v1\ADMIN\UserController@store')->name('user_create');
	Route::get('/admin/users', 'v1\ADMIN\UserController@index')->name('users');
	Route::get('/admin/users/{id}', 'v1\ADMIN\UserController@info')->name('user_edit');
	Route::post('/admin/users/update', 'v1\ADMIN\UserController@update')->name('user_update');
	Route::get('/admin/users/delete/{id}', 'v1\ADMIN\UserController@delete')->name('user_delete');

	Route::get('/admin/orders/create', 'v1\ADMIN\OrderController@show')->name('order_create');
	Route::post('/admin/orders/create', 'v1\ADMIN\OrderController@store')->name('order_create');
	Route::get('/admin/orders', 'v1\ADMIN\OrderController@index')->name('orders');
	Route::get('/admin/orders/{id}', 'v1\ADMIN\OrderController@details')->name('order_details');
	Route::post('/admin/orders/update', 'v1\ADMIN\OrderController@update')->name('order_update');
	Route::get('/admin/orders/delete/{id}', 'v1\ADMIN\OrderController@delete')->name('order_delete');
	Route::get('/admin/order_sent/{id}', 'v1\ADMIN\OrderController@sent')->name('order_sent');

	Route::get('/admin/pays', 'v1\ADMIN\OrderController@pays')->name('pays');

	Route::get('/admin/messages', 'v1\ADMIN\AdminController@messages')->name('messages');
	Route::get('/admin/messages/sms', 'v1\ADMIN\AdminController@messages_sms')->name('messages');
	Route::get('/admin/messages/push', 'v1\ADMIN\AdminController@messages_push')->name('messages');
	Route::post('/admin/messages/sms', 'v1\ADMIN\AdminController@messages_send_sms')->name('messages');
	Route::post('/admin/messages/push', 'v1\ADMIN\AdminController@messages_send_push')->name('messages');

	Route::post('/admin/confirm/message', 'v1\ADMIN\AdminController@messages_send_confirm')->name('messages');
	Route::get('/admin/confirm/{id}/{code}', 'v1\ADMIN\AdminController@confirmInfo')->name('confirm');
	Route::get('/admin/pop/{id}', 'v1\ADMIN\AdminController@popUser')->name('pop');

	Route::get('/admin/accounting', 'v1\ADMIN\AdminController@accounting')->name('accounting');

	Route::get('/admin/banners/create', 'v1\ADMIN\AdminController@banner_show')->name('banner_show');
	Route::post('/admin/banners/create', 'v1\ADMIN\AdminController@banner_create')->name('banner_create');
	Route::get('/admin/banners', 'v1\ADMIN\AdminController@banners')->name('banners');
	Route::get('/admin/banners/{id}', 'v1\ADMIN\AdminController@banner_edit')->name('banner_edit');
	Route::post('/admin/banners/update', 'v1\ADMIN\AdminController@banner_update')->name('banner_update');
	Route::get('/admin/banners/delete/{id}', 'v1\ADMIN\AdminController@banner_delete')->name('banner_delete');

	Route::get('/admin/comments', 'v1\ADMIN\AdminController@comments')->name('comments');

	Route::get('/checkout', 'v1\market\MainController@checkout')->name('checkout');
	Route::get('/pay_confirm', 'v1\market\MainController@pay_confirm')->name('pay_confirm');
});

Route::get('/search', 'v1\ADMIN\AdminController@search');
Route::get('/admin/search', 'v1\ADMIN\AdminController@search');

Route::get('/profile', 'v1\MARKET\UserController@profile');
Route::get('/orders', 'v1\MARKET\UserController@orders');

Route::get('category/{level}/{id}', 'v1\market\CategoryController@index');
Route::get('/addToCart', 'v1\ProductController@addToCart');
Route::get('/removeFromCart', 'v1\ProductController@removeFromCart');
Route::get('/pay', 'v1\market\MainController@pay')->name('pay');
Route::post('/callback', 'v1\market\MainController@callback');
Route::get('/admin/downloadFactor/{id}', 'v1\ADMIN\OrderController@downloadFactor');

Route::get('/contact_us', 'v1\market\MainController@contact_us');
Route::get('/about', 'v1\market\MainController@about');
Route::get('/privacy', 'v1\market\MainController@privacy');
Route::get('/terms', 'v1\market\MainController@terms');
Route::get('/comment', 'v1\market\MainController@comment');
Route::post('/comment/send', 'v1\market\MainController@sendComment');
Route::get('/logo', function () {
	return view('market.logo');
});
Route::get('/asnaf', function () {
	return view('market.asnaf');
});

Route::get('/android/pay/{id}', 'v1\OrderController@pay');
Route::get('/website/pay', 'v1\OrderController@web_pay');
Route::get('/pay/{price}', 'v1\OrderController@pay_test');
Route::post('/callback2', 'v1\OrderController@call_back');
Route::post('/callback3', 'v1\OrderController@call_back2');
Route::get('/factor/{code}', 'v1\OrderController@getFactor');

Route::get('/armin', 'v1\MainController@armin');
Route::get('/test', 'v1\MainController@test');
Route::get('/info', 'TelegramController@info');
Route::get('/winfo', 'TelegramController@info_webhook');
Route::get('/set', 'TelegramController@set');
Route::post('/531370522:AAHYvRhHW7Y2HRIOQszk5MfsZTbJNsy29Dw/webhook', 'TelegramController@webhook');

Route::get('/phpinfo', function () {
	return phpinfo();
});
