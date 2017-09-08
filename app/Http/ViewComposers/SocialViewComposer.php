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

        $view->with('social', [
            'facebook' => $facebook
        ]);
    }
}