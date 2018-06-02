<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

Route::resource('/v1/sellers', v1\API\SellerController::class, [
	'except' => [
		'create',
		'edit'
	]
]);

Route::resource('/v1/products', v1\API\ProductController::class, [
	'except' => [
		'create',
		'edit'
	]
]);

Route::post('/v1/products_all', 'v1\API\ProductController@sectionLoad');

Route::resource('/v1/users', v1\API\UserController::class, [
	'except' => [
		'create',
		'edit',
		'update'
	]
]);

Route::resource('v1/login', v1\API\LoginController::class, [
	'except' => [
		'create',
		'edit',
		'destroy',
		'show',
		'update',
		'index'
	]
]);

Route::resource('v1/main', \v1\API\MainController::class, [
	'except' => [
		'create',
		'edit',
		'destroy',
		'show',
		'store',
		'update'
	]
]);

Route::resource('/v1/comments', v1\API\CommentController::class, [
	'except' => [
		'create',
		'edit'
	]
]);

Route::resource('/v1/orders', v1\API\OrderController::class, [
	'except' => [
		'create',
		'edit'
	]
]);

Route::post('/v1/categories', 'v1\API\CategoryController@getCategories');
Route::post('/v1/categories_all', 'v1\API\CategoryController@sectionLoad');
Route::post('/callback', 'v1\API\OrderController@callback');
Route::post('/v1/search', 'v1\API\MainController@search');
Route::post('/v1/verifyPhone', 'v1\API\UserController@phoneVerification');
Route::post('/v1/verifyPhoneOK', 'v1\API\UserController@phoneVerificationOK');
Route::post('/v1/products_detail', 'v1\API\ProductController@getDetails');
Route::post('/v1/downloadLink', 'v1\API\MainController@downloadLink');
Route::get('/v1/downloadLink', 'v1\API\MainController@downloadLink');
Route::get('/v1/getProductByID/{id}', 'v1\API\ProductController@getProduct');
Route::post('/v1/user_orders', 'v1\API\OrderController@userOrders');
Route::post('/v1/user_update', 'v1\API\UserController@updateUser');
Route::post('/v1/checkConfirm', 'v1\API\UserController@checkConfirm');
Route::post('/v1/resetPassword', 'v1\API\UserController@resetPassword');
Route::post('/v1/updatePassword', 'v1\API\UserController@updatePassword');
Route::post('/v1/sync_id', 'v1\API\UserController@syncID');
Route::post('/v1/temp_order', 'v1\API\OrderController@storeTemp');
Route::post('/v1/complete_order', 'v1\API\OrderController@completeOrder');
Route::post('/v1/test', 'v1\API\MainController@test2');

Route::get('/v1/generateWallets', 'v1\API\WalletController@generateWallets');
Route::get('/v1/getWallet_byId/{id}', 'v1\API\WalletController@getWalletByID');
Route::get('/v1/getWallet_byUser/{id}', 'v1\API\WalletController@getWalletByUser');
Route::post('/v1/getWalletCode', 'v1\API\WalletController@getWalletCode');
Route::post('/v1/getTransferConfirmationByID', 'v1\API\WalletController@getTransferConfirmationByID');
Route::post('/v1/getTransferConfirmationByCode', 'v1\API\WalletController@getTransferConfirmationByCode');
Route::post('/v1/transferMoney', 'v1\API\WalletController@transferMoney');
Route::post('/v1/transactions', 'v1\API\WalletController@getTransactions');

Route::get('/200', function () {
	return response()->json([
		'error' => false,
	], 200);
});