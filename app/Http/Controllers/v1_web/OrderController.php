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


use App\Order;

class OrderController
{
    public function index()
    {
        $orders = Order::orderBy("created_at", "desc")->get();
        return view('admin.orders')
            ->withTitle("Orders")
            ->withOrders($orders);
    }
}