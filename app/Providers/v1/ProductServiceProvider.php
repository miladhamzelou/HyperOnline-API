<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Providers\v1;

use App\Services\v1\ProductService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ProductServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Validator::extend('productSeller', 'App\Validator\MyValidator@validateSeller');
    }

    public function register()
    {
        $this->app->bind(ProductService::class, function () {
            return new ProductService();
        });
    }
}