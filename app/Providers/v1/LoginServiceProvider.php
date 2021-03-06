<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Providers\v1;

use App\Services\v1\UserService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class LoginServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Validator::extend('userPhone', 'App\Validator\MyValidator@validatePhone');
    }

    public function register()
    {
        $this->app->bind(UserService::class, function () {
            return new UserService();
        });
    }
}