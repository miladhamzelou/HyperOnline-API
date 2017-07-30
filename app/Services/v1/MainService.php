<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Services\v1;

use App\Product;
use App\Order;

include(app_path() . '/Common/jdf.php');

class MainService
{
    public function getData()
    {
        $new = Product::where("confirmed", 1)->orderBy('created_at', 'desc')->take(8)->get();

        return null;
    }
}