<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    protected $except = [
        'api/*',
        'api/v1/*',
        'callback',
        'callback2',
        'callback3',
        '531370522:AAHYvRhHW7Y2HRIOQszk5MfsZTbJNsy29Dw/webhook'
    ];
}
