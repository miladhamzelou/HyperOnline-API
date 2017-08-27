<?php

define('_MPDF_TTFONTDATAPATH',__DIR__.'/../storage/framework/pdf/fonts/');
define('_MPDF_TEMP_PATH',__DIR__.'/../storage/framework/pdf/');
define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Composer Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so we do not have to manually load any of
| our application's PHP classes. It just feels great to relax.
|
*/

require __DIR__.'/../vendor/autoload.php';
