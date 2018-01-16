<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

Route::resource('/v1/sellers', v1\SellerController::class, [
    'except' => [
        'create',
        'edit'
    ]
]);

Route::resource('/v1/products', v1\ProductController::class, [
    'except' => [
        'create',
        'edit'
    ]
]);

Route::post('/v1/products_all', 'v1\ProductController@sectionLoad');

Route::resource('/v1/users', v1\UserController::class, [
    'except' => [
        'create',
        'edit',
        'update'
    ]
]);

Route::resource('v1/login', v1\LoginController::class, [
    'except' => [
        'create',
        'edit',
        'destroy',
        'show',
        'update',
        'index'
    ]
]);

Route::resource('v1/main', v1\MainController::class, [
    'except' => [
        'create',
        'edit',
        'destroy',
        'show',
        'store',
        'update'
    ]
]);

Route::resource('/v1/comments', v1\CommentController::class, [
    'except' => [
        'create',
        'edit'
    ]
]);

Route::resource('/v1/orders', v1\OrderController::class, [
    'except' => [
        'create',
        'edit'
    ]
]);

Route::post('/v1/categories', 'v1\CategoryController@getCategories');
Route::post('/v1/categories_all', 'v1\CategoryController@sectionLoad');
Route::post('/callback', 'v1\OrderController@callback');
Route::post('/v1/search', 'v1\MainController@search');
Route::post('/v1/verifyPhone', 'v1\UserController@phoneVerification');
Route::post('/v1/verifyPhoneOK', 'v1\UserController@phoneVerificationOK');
Route::post('/v1/products_detail', 'v1\ProductController@getDetails');
Route::post('/v1/downloadLink', 'v1\MainController@downloadLink');
Route::get('/v1/downloadLink', 'v1\MainController@downloadLink');
Route::get('/v1/getProductByID/{id}', 'v1\ProductController@getProduct');
Route::post('/v1/user_orders', 'v1\OrderController@userOrders');
Route::post('/v1/user_update', 'v1\UserController@updateUser');
Route::post('/v1/checkConfirm', 'v1\UserController@checkConfirm');
Route::post('/v1/resetPassword', 'v1\UserController@resetPassword');
Route::post('/v1/updatePassword', 'v1\UserController@updatePassword');
Route::post('/v1/sync_id', 'v1\UserController@syncID');
Route::post('/v1/temp_order', 'v1\OrderController@storeTemp');
Route::post('/v1/complete_order', 'v1\OrderController@completeOrder');