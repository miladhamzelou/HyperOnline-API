<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Services\v1;

use App\Jobs\SendEmail;
use App\Jobs\SendSMS;
use App\Order;
use App\Product;
use App\Seller;
use App\Support;
use App\User;
use Illuminate\Http\Request;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class OrderService
{
    protected $supportedIncludes = [
        'seller' => 'seller',
        'user' => 'user'
    ];

    protected $clauseProperties = [
        'unique_id'
    ];

    /**
     * @param $parameters
     * @return array
     */
    public function getOrders($parameters)
    {
        if (empty($parameters)) return $this->filterOrders(Order::all());

        $withKeys = $this->getWithKeys($parameters);
        $whereClauses = $this->getWhereClauses($parameters);

        $orders = Order::with($withKeys)->where($whereClauses)->get();

        return $this->filterOrders($orders, $withKeys);
    }

    /**
     * @param $request
     * @return bool
     */
    public function createOrder($request)
    {
        $order = new Order();
        $user = User::where('unique_id', $request->get('user'))->firstOrFail();
        $seller = Seller::where('unique_id', $request->get('seller'))->firstOrFail();

        $order->unique_id = uniqid('', false);
        $order->seller_id = $seller->unique_id;
        $order->user_id = $user->unique_id;
        $order->code = $request->get('code');
        $order->seller_name = $seller->name;
        $order->user_name = $user->name;
        $order->user_phone = $user->phone;
        $order->stuffs = ltrim(rtrim($request->get('stuffs'), ','), ',');
        $order->stuffs_id = ltrim(rtrim($request->get('stuffs_id'), ','), ',');
        $order->stuffs_count = ltrim(rtrim($request->get('stuffs_count'), ','), ',');
        $order->price_send = 5000;
        $order->hour = $request->get('hour');
        $order->pay_method = $request->get('method');
        $order->description = $request->get('description');
        $order->create_date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());

        $ids = explode(',', $order->stuffs_id);
        $products = array();
        foreach ($ids as $id) {
            $p = Product::where("unique_id", $id)->firstOrFail()->toArray();
            array_push($products, $p);
        }
        $price_original = 0;
        $tPrice = 0;
        $counts = explode(',', $order->stuffs_count);
        foreach ($products as $index => $pr) {
            $product = Product::where("unique_id", $pr['unique_id'])->firstOrFail();
            $product->sell = $product->sell + 1;
//            $product->count = $product->count - 1;
            $price_original += $product->price_original * $counts[$index];
            $tPrice += $product->price * $counts[$index];
            $product->save();
        }
        if ($tPrice < 35000) $tPrice += 5000;
        $order->price = $tPrice;
        $order->price_original = $price_original;
        $order->save();

        $data = [
            "products" => $products,
            "counts" => $counts,
            "user_name" => $order->user_name,
            "user_phone" => $order->user_phone,
            "user_address" => User::where("unique_id", $order->user_id)->firstOrFail()->address,
            "total" => $order->price,
            "hour" => $order->hour,
            "description" => $order->description
        ];
        $pdf = PDF::loadView('pdf.factor', $data);
        $pdf->save(public_path('/ftp/factors/' . $order->code . '.pdf'));

        $support = new Support();
        $support->unique_id = uniqid('', false);
        $support->section = "سفارش جدید";
        $support->body = "سفارش جدید ثبت شد";
        $support->log = 0;

        SendEmail::dispatch([
            "to" => "hyper.online.h@gmail.com",
            "body" => "سفارش جدید ثبت شد"
        ], 1);
        SendSMS::dispatch([
            "msg" => ["سفارش جدید ثبت شد"],
            "phone" => ["09188167800"]
        ]);

        return true;
    }

    /**
     * @param $request
     * @param $id
     * @return bool
     */
    public function updateOrder($request, $id)
    {
        $order = Order::where('unique_id', $id)->firstOrFail();

        if (app('request')->exists('stuffs')) $order->stuffs = $request->input('stuffs');

        if (app('request')->exists('price')) $order->price = $request->input('price');

        if (app('request')->exists('description')) $order->description = $request->input('description');

        $order->save();

        return true;
    }

    /**
     * @param $id
     */
    public function deleteOrder($id)
    {
        $order = Order::where('unique_id', $id)->firstOrFail();
        $order->delete();
    }

    public function userOrders(Request $request)
    {
        $orders = Order::where("user_id", $request->get('unique_id'))
            ->orderBy("created_at", "desc")
            ->get();
        return $this->filterOrders($orders);
    }

    /**
     * @param $orders
     * @param array $keys
     * @return array
     */
    protected function filterOrders($orders, $keys = [])
    {
        $data = [];
        foreach ($orders as $order) {
            $entry = [
                'unique_id' => $order->unique_id,
                'seller_id' => $order->seller_id,
                'seller_name' => $order->seller_name,
                'user_id' => $order->user_id,
                'stuffs' => $order->stuffs,
                'price' => $order->price,
                'code' => $order->code,
                'hour' => $order->hour,
                'method' => $order->method,
                'status' => $order->status,
                'description' => $order->description,
                'create_date' => $order->create_date
            ];

            if (in_array('seller', $keys))
                $entry['seller'] = [
                    'name' => Seller::where('unique_id', $order->seller_id)->get()[0]->name
                ];

            if (in_array('user', $keys)) {
                $user = User::where('unique_id', $order->seller_id)->get()[0];
                $entry['user'] = [
                    'name' => $user->name,
                    'phone' => $user->phone
                ];
            }

            $data[] = $entry;
        }
        return $data;
    }

    /**
     * @param $parameters
     * @return array
     */
    protected function getWithKeys($parameters)
    {
        $withKeys = [];

        if (isset($parameters['include'])) {
            $includeParms = explode(',', $parameters['include']);
            $includes = array_intersect($this->supportedIncludes, $includeParms);
            $withKeys = array_keys($includes);
        }

        return $withKeys;
    }

    /**
     * @param $parameters
     * @return array
     */
    protected function getWhereClauses($parameters)
    {
        $clause = [];

        foreach ($this->clauseProperties as $prop)
            if (in_array($prop, array_keys($parameters)))
                $clause[$prop] = $parameters[$prop];

        return $clause;
    }

    protected function getCurrentTime()
    {
        $now = date("Y-m-d", time());
        $time = date("H:i:s", time());
        return $now . ' ' . $time;
    }

    protected function getDate($date)
    {
        $now = explode(' ', $date)[0];
        $time = explode(' ', $date)[1];
        list($year, $month, $day) = explode('-', $now);
        list($hour, $minute, $second) = explode(':', $time);
        $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
        $date = jDate("Y/m/d", $timestamp);
        return $date;
    }

    protected function getTime($date)
    {
        $now = explode(' ', $date)[0];
        $time = explode(' ', $date)[1];
        list($year, $month, $day) = explode('-', $now);
        list($hour, $minute, $second) = explode(':', $time);
        $timestamp = mktime($hour, $minute, $second, $month, $day, $year);
        $date = jDate("H:i", $timestamp);
        return $date;
    }
}