<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

/**
 * Created by PhpStorm.
 * User: root
 * Date: 8/14/17
 * Time: 6:18 PM
 */

namespace app\Http\Controllers\v1_web;


use App\Seller;

class SellerController
{
    public function index()
    {
        $sellers = Seller::orderBy("created_at", "desc")->get();
        return view('admin.sellers')
            ->withTitle("Sellers")
            ->withSellers($sellers);
    }
}