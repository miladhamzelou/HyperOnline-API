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
use App\Pay;

class OrderController
{
    public function index()
    {
        $orders = Order::orderBy("created_at", "desc")->get();
        return view('admin.orders')
            ->withTitle("سفارشات")
            ->withOrders($this->fixPrice($orders));
    }

    public function pays()
    {
        $pays = Pay::get();
        return view('admin.pays')
            ->withTitle("تراکنش ها")
            ->withPays($pays);
    }

    public function details($id)
    {
        $order = Order::find($id);
        $order->price = $this->formatMoney($order->price);
        return view('admin.order_details')
            ->withTitle("سفارش")
            ->withOrder($order);
    }

    protected function fixPrice($items)
    {
        foreach ($items as $item)
            $item->price = $this->formatMoney($item->price);
        return $items;
    }

    protected function formatMoney($number, $fractional = false)
    {
        if ($fractional)
            $number = sprintf('%.2f', $number);
        while (true) {
            $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
            if ($replaced != $number)
                $number = $replaced;
            else
                break;
        }
        return $number;
    }
}