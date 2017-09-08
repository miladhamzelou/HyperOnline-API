<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Providers\v1;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function boot(ViewFactory $view)
    {
        $view->composer('*', "App\Http\ViewComposers\SocialViewComposer");
    }

    public function register()
    {

    }
}