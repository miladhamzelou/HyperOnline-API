<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Providers\v1;

use App\Services\v1\SellerService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class SellerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Validator::extend('sellerType', 'App\Validator\MyValidator@validateType');
        Validator::extend('sellerPhone', 'App\Validator\MyValidator@validatePhone');
        Validator::extend('sellerAuthor', 'App\Validator\MyValidator@validateAuthor');
    }

    public function register()
    {
        $this->app->bind(SellerService::class, function () {
            return new SellerService();
        });
    }
}