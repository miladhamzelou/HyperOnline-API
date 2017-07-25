<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Providers\v1;

use App\Services\v1\CommentService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class CommentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Validator::extend('commentTarget', 'App\Validator\MyValidator@validateTarget');
        Validator::extend('commentUser', 'App\Validator\MyValidator@validateUser');
    }

    public function register()
    {
        $this->app->bind(CommentService::class, function () {
            return new CommentService();
        });
    }
}