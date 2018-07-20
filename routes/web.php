<?php

Route::auth();

Route::get('/', 'v1\MARKET\MainController@index')->name('root');
Route::get('/home', 'v1\MARKET\MainController@index')->name('home');

Route::get('/profile', 'v1\ADMIN\UserController@profile')->name('profile');

Route::group(['prefix' => 'management', 'middleware' => ['auth']], function () {
	Route::get('/', 'v1\ADMIN\AdminController@admin')->name('admin');
	Route::get('/database', 'v1\ADMIN\AdminController@database_get')->name('database');
	Route::post('/database', 'v1\ADMIN\AdminController@database_store')->name('database');
	Route::get('/support', 'v1\ADMIN\AdminController@support')->name('support');
	Route::post('/support', 'v1\ADMIN\AdminController@support_send')->name('support');

	Route::get('/setting', 'v1\ADMIN\AdminController@setting')->name('setting');
	Route::post('/setting', 'v1\ADMIN\AdminController@setting_send')->name('setting');
	Route::get('/setting/delete_log', 'v1\ADMIN\AdminController@delete_log')->name('setting');
	Route::get('/setting/resetMostSell', 'v1\ADMIN\AdminController@resetMostSell')->name('setting');
	Route::get('/setting/confirmAllPhones', 'v1\ADMIN\AdminController@confirmAllPhones')->name('setting');
	Route::post('/setting/updateOffline', 'v1\ADMIN\AdminController@updateOffline')->name('setting');

	Route::get('/products/create', 'v1\ADMIN\ProductController@show')->name('product_create');
	Route::post('/products/create', 'v1\ADMIN\ProductController@store')->name('product_create');
	Route::get('/products', 'v1\ADMIN\ProductController@index')->name('products');
	Route::get('/products/{id}', 'v1\ADMIN\ProductController@edit')->name('product_edit');
	Route::post('/products/update', 'v1\ADMIN\ProductController@update')->name('product_update');
	Route::get('/products/delete/{id}', 'v1\ADMIN\ProductController@delete')->name('product_delete');
	Route::get('/products/delete_photo/{id}', 'v1\ADMIN\ProductController@delete_photo')->name('product_delete');
	Route::get('/products_inactive', 'v1\ADMIN\ProductController@inactive')->name('products_inactive');
	Route::get('/products_active', 'v1\ADMIN\ProductController@active')->name('products_active');

	Route::get('/categories/create/{level}', 'v1\ADMIN\CategoryController@show')->name('category_create');
	Route::post('/categories/create/{level}', 'v1\ADMIN\CategoryController@store')->name('category_create');
	Route::get('/categories', 'v1\ADMIN\CategoryController@index')->name('categories');
	Route::get('/categories/{level}/{id}', 'v1\ADMIN\CategoryController@edit')->name('category_edit');
	Route::post('/categories/update/{level}', 'v1\ADMIN\CategoryController@update')->name('category_update');
	Route::get('/categories/delete/{level}/{id}', 'v1\ADMIN\CategoryController@delete')->name('category_delete');
	Route::get('/categories/delete_photo/{level}/{id}', 'v1\ADMIN\CategoryController@delete_photo')->name('category_delete');

	Route::get('/authors/create', 'v1\ADMIN\AuthorController@show')->name('author_create');
	Route::post('/authors/create', 'v1\ADMIN\AuthorController@store')->name('author_create');
	Route::get('/authors', 'v1\ADMIN\AuthorController@index')->name('authors');
	Route::get('/authors/{id}', 'v1\ADMIN\AuthorController@edit')->name('author_edit');
	Route::post('/authors/update', 'v1\ADMIN\AuthorController@update')->name('author_update');
	Route::get('/authors/delete/{id}', 'v1\ADMIN\AuthorController@delete')->name('author_delete');

	Route::get('/sellers/create', 'v1\ADMIN\SellerController@show')->name('seller_create');
	Route::post('/sellers/create', 'v1\ADMIN\SellerController@store')->name('seller_create');
	Route::get('/sellers', 'v1\ADMIN\SellerController@index')->name('sellers');
	Route::get('/sellers/{id}', 'v1\ADMIN\SellerController@edit')->name('seller_edit');
	Route::post('/sellers/update', 'v1\ADMIN\SellerController@update')->name('seller_update');
	Route::get('/sellers/delete/{id}', 'v1\ADMIN\SellerController@delete')->name('seller_delete');

	Route::get('/users/create', 'v1\ADMIN\UserController@show')->name('user_create');
	Route::post('/users/create', 'v1\ADMIN\UserController@store')->name('user_create');
	Route::get('/users', 'v1\ADMIN\UserController@index')->name('users');
	Route::get('/users/{id}', 'v1\ADMIN\UserController@info')->name('user_edit');
	Route::post('/users/update', 'v1\ADMIN\UserController@update')->name('user_update');
	Route::get('/users/delete/{id}', 'v1\ADMIN\UserController@delete')->name('user_delete');
	Route::post('/users/charge', 'v1\ADMIN\UserController@chargeWallet')->name('user_charge');

	Route::get('/orders/create', 'v1\ADMIN\OrderController@show')->name('order_create');
	Route::post('/orders/create', 'v1\ADMIN\OrderController@store')->name('order_create');
	Route::get('/orders', 'v1\ADMIN\OrderController@index')->name('orders');
	Route::get('/orders/{id}', 'v1\ADMIN\OrderController@details')->name('order_details');
	Route::post('/orders/update', 'v1\ADMIN\OrderController@update')->name('order_update');
	Route::get('/orders/delete/{id}', 'v1\ADMIN\OrderController@delete')->name('order_delete');
	Route::get('/order_sent/{id}', 'v1\ADMIN\OrderController@sent')->name('order_sent');

	Route::get('/pays', 'v1\ADMIN\OrderController@pays')->name('pays');

	Route::get('/messages', 'v1\ADMIN\AdminController@messages')->name('messages');
	Route::get('/messages/sms', 'v1\ADMIN\AdminController@messages_sms')->name('messages');
	Route::get('/messages/push', 'v1\ADMIN\AdminController@messages_push')->name('messages');
	Route::post('/messages/sms', 'v1\ADMIN\AdminController@messages_send_sms')->name('messages');
	Route::post('/messages/push', 'v1\ADMIN\AdminController@messages_send_push')->name('messages');

	Route::post('/confirm/message', 'v1\ADMIN\AdminController@messages_send_confirm')->name('messages');
	Route::get('/confirm/{id}/{code}', 'v1\ADMIN\AdminController@confirmInfo')->name('confirm');
	Route::get('/pop/{id}', 'v1\ADMIN\AdminController@popUser')->name('pop');

	Route::get('/accounting', 'v1\ADMIN\AdminController@accounting')->name('accounting');

	Route::get('/banners/create', 'v1\ADMIN\AdminController@banner_show')->name('banner_show');
	Route::post('/banners/create', 'v1\ADMIN\AdminController@banner_create')->name('banner_create');
	Route::get('/banners', 'v1\ADMIN\AdminController@banners')->name('banners');
	Route::get('/banners/{id}', 'v1\ADMIN\AdminController@banner_edit')->name('banner_edit');
	Route::post('/banners/update', 'v1\ADMIN\AdminController@banner_update')->name('banner_update');
	Route::get('/banners/delete/{id}', 'v1\ADMIN\AdminController@banner_delete')->name('banner_delete');

	Route::get('/comments', 'v1\ADMIN\AdminController@comments')->name('comments');

	Route::get('/checkout', 'v1\MARKET\MainController@checkout')->name('checkout');
	Route::post('/pay_confirm', 'v1\MARKET\MainController@pay_confirm')->name('pay_confirm');

	Route::get('/logs/{type}', 'v1\ADMIN\AdminController@logs')->name('logs');
});

Route::get('/search', 'v1\ADMIN\AdminController@search');
Route::get('/search', 'v1\ADMIN\AdminController@search');

Route::get('/profile', 'v1\MARKET\UserController@profile');
Route::get('/orders', 'v1\MARKET\UserController@orders');

Route::get('category/{level}/{id}', 'v1\MARKET\CategoryController@index');
Route::get('/addToCart', 'v1\API\ProductController@addToCart');
Route::get('/removeFromCart', 'v1\MARKET\ProductController@removeFromCart');
Route::get('/pay', 'v1\MARKET\MainController@pay')->name('pay');
Route::post('/callback', 'v1\MARKET\MainController@callback');
Route::get('/downloadFactor/{id}', 'v1\ADMIN\OrderController@downloadFactor');

Route::get('/contact_us', 'v1\MARKET\MainController@contact_us');
Route::get('/about', 'v1\MARKET\MainController@about');
Route::get('/privacy', 'v1\MARKET\MainController@privacy');
Route::get('/terms', 'v1\MARKET\MainController@terms');
Route::get('/comment', 'v1\MARKET\MainController@comment');
Route::post('/comment/send', 'v1\MARKET\MainController@sendComment');
Route::get('/logo', function () {
	return view('market.logo');
});
Route::get('/asnaf', function () {
	return view('market.asnaf');
});

Route::get('/android/pay/{id}', 'v1\API\OrderController@pay');
Route::get('/website/pay', 'v1\API\OrderController@web_pay');
Route::get('/pay/{price}', 'v1\API\OrderController@pay_test');
Route::post('/callback2', 'v1\API\OrderController@call_back');
Route::post('/callback3', 'v1\API\OrderController@call_back2');
Route::get('/factor/{code}', 'v1\API\OrderController@getFactor');

Route::get('/armin', 'v1\API\MainController@armin');
Route::get('/test', 'v1\API\MainController@test');
Route::get('/info', 'TelegramController@info');
Route::get('/winfo', 'TelegramController@info_webhook');
Route::get('/set', 'TelegramController@set');
Route::post('/531370522:AAHYvRhHW7Y2HRIOQszk5MfsZTbJNsy29Dw/webhook', 'TelegramController@webhook');

Route::get('/wallet/pay/{id}', 'v1\API\WalletController@pay');
Route::post('/wallet_callback', 'v1\API\WalletController@callBack');

Route::get('/phpinfo', function () {
	return phpinfo();
});
