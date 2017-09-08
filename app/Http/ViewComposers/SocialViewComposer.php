<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

class SocialViewComposer
{

    public function compose(View $view)
    {
        $facebook = "https://facebook.com/hatamiarash7";
        $twitter = "https://facebook.com/hatamiarash7";
        $pinterest = "https://facebook.com/hatamiarash7";
        $google = "https://facebook.com/hatamiarash7";

        $view->with('social', [
            'facebook' => $facebook,
            'twitter' => $twitter,
            'pinterest' => $pinterest,
            'google' => $google,
        ]);
    }
}