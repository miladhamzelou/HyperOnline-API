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

Route::resource('/v1/users', v1\UserController::class, [
    'except' => [
        'create',
        'edit'
    ]
]);

Route::resource('users', 'v1\UserController@store');

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