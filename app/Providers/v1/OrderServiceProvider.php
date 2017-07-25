<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Providers\v1;

use App\Services\v1\OrderService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class OrderServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Validator::extend('orderSeller', 'App\Validator\MyValidator@validateSeller');
        Validator::extend('orderUser', 'App\Validator\MyValidator@validateUser');
        Validator::extend('userPhone', 'App\Validator\MyValidator@validatePhone');
    }

    public function register()
    {
        $this->app->bind(OrderService::class, function () {
            return new OrderService();
        });
    }
}