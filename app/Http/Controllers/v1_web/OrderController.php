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
use App\User;

class OrderController
{
    public function index()
    {
        $orders = Order::orderBy("created_at", "desc")->get();

        return view('admin.orders')
            ->withTitle("سفارشات")
            ->withOrders($this->fix($orders));
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
        $this->addInfo($order);
        $order->price = $this->formatMoney($order->price);
        $order->pay_method = ($order->pay_method == "online") ? "آنلاین" : "در محل";
        $user = User::where("unique_id", $order->user_id)->firstOrFail();
        $address = $user->state . ' - ' . $user->city . ' ///////// ' . $user->address;
        return view('admin.order_details')
            ->withTitle("سفارش")
            ->withAddress($address)
            ->withOrder($order);
    }

    protected function fix($items)
    {
        foreach ($items as $item)
            $this->addInfo($item);
        return $this->fixPrice($items);
    }

    protected function addInfo(&$item)
    {
        $stuff = explode(',', $item->stuffs);
        $stuff_count = explode(',', $item->stuffs_count);
        $stuff_desc = explode(',', $item->stuffs_desc);
        $final = "";
        foreach (array_values($stuff) as $i => $value) {
            $final .= $value . ' ( ' . $stuff_desc[$i] . ' )( ' . $stuff_count[$i] . ' عدد ) :--: ';
        }
        $item->stuffs = substr($final, 0, -6);
    }

    protected function fixPrice($items)
    {
        foreach ($items as $item) {
            $item->price = $this->formatMoney($item->price);
            $item->price_send = $this->formatMoney($item->price_send);
        }

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