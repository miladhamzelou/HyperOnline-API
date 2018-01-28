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
        $seller = Seller::where('unique_id', "vbkYwlL98I3F3")->firstOrFail();

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
        $order->price_send = 4000;
        $order->hour = $request->get('hour');
        $method = -1;
        if (app('request')->exists('method')) {
            $method = $request->get('method');
            if ($method == 1)
                $order->pay_method = 'online';
            else
                $order->pay_method = 'place';
        } else
            $order->pay_method = 'online';
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
        $tOff = 0;
        $tFinal = 0;
        $counts = explode(',', $order->stuffs_count);
        $desc = '';
        foreach ($products as $index => $pr) {
            $product = Product::where("unique_id", $pr['unique_id'])->firstOrFail();

            $product->sell = $product->sell + 1;
            if ($order->code != '-1')
                $product->count = $product->count - 1;
            if ($product->description)
                $desc .= $product->description . ',';
            else
                $desc .= '-,';

            $price_original += $product->price_original * $counts[$index];
            $tPrice += $product->price * $counts[$index];
            $tOff += $product->price * $product->off / 100 * $counts[$index];
            $tFinal += ($product->price - ($product->price * $product->off / 100)) * $counts[$index];

            $product->save();
        }
        $send_price = Seller::firstOrFail()->send_price;
        if ($tPrice < 30000) $tPrice += 4000;
        else $send_price = 0;
        $order->price = $tPrice;
        $order->price_original = $price_original;
        $order->stuffs_desc = ltrim(rtrim($desc, ','), ',');
        $order->save();

        $data = [
            "products" => $products,
            "counts" => $counts,
            "desc" => explode(',', $order->stuffs_desc),
            "user_name" => $order->user_name,
            "user_phone" => $order->user_phone,
            "user_code" => $user->code,
            "user_address" => $user->state . '-' . $user->city . ' : ' . $user->address,
            "total" => $tPrice,
            "off" => $tOff,
            "final" => $tFinal,
            "hour" => $order->hour,
            "description" => $order->description,
            "date" => $order->create_date,
            "code" => $order->code,
            "send_price" => $send_price
        ];
        $pdf = PDF::loadView('pdf.factor', $data);
        $pdf->save(public_path('/ftp/factors/' . $order->code . '.pdf'));

//        $support = new Support();
//        $support->unique_id = uniqid('', false);
//        $support->section = "سفارش جدید";
//        $support->body = "سفارش جدید ثبت شد";
//        $support->log = 0;


        $this->addInfo($order);

        $type = "";
        if ($method == 1) $type = "آنلاین";
        else if ($method == 0) $type = "حضوری";

        SendEmail::dispatch([
            "to" => "hyper.online.h@gmail.com",
            "body" => "سفارش ( " . $type . " ) جدید ثبت شد",
            "order" => [
                "code" => $order->code,
                "user_name" => $order->user_name,
                "user_phone" => $order->user_phone,
                "stuffs" => $order->stuffs,
                "hour" => $order->hour,
                "price" => $order->price,
                "desc" => $order->description,
            ]
        ], 1)
            ->onQueue('email');

        SendSMS::dispatch([
            "msg" => ["سفارش ( " . $type . " ) جدید ثبت شد"],
            "phone" => ["09188167800"]
        ])
            ->onQueue('sms');

//        CheckProducts::dispatch()
//            ->onQueue('email')
//            ->delay(Carbon::now()->addMinutes(1));
        return true;
    }

    public function tempOrder(Request $request)
    {
        $order = new Order();
        $user = User::where('unique_id', $request->get('user'))->firstOrFail();
        $seller = Seller::where('unique_id', "vbkYwlL98I3F3")->firstOrFail();
        $send_price = $seller->send_price;

        $uid = uniqid('', false);
        $order->unique_id = $uid;
        $order->seller_id = $seller->unique_id;
        $order->user_id = $user->unique_id;
        $order->code = $uid;
        $order->seller_name = $seller->name;
        $order->user_name = $user->name;
        $order->user_phone = $user->phone;
        $order->stuffs = ltrim(rtrim($request->get('stuffs'), ','), ',');
        $order->stuffs_id = ltrim(rtrim($request->get('stuffs_id'), ','), ',');
        $order->stuffs_count = ltrim(rtrim($request->get('stuffs_count'), ','), ',');
        $order->price_send = $send_price;
        $order->hour = $request->get('hour');
        if (app('request')->exists('method')) {
            $method = $request->get('method');
            if ($method == 1)
                $order->pay_method = 'online';
            else
                $order->pay_method = 'place';
        } else
            $order->pay_method = 'online';
        $order->description = $request->get('description');
        $order->create_date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());

        $ids = explode(',', $order->stuffs_id);
        $products = array();
        foreach ($ids as $id) {
            $p = Product::where("unique_id", $id)->firstOrFail()->toArray();
            array_push($products, $p);
        }
        $price_original = 0;
        //$tPrice = 0;
        $tOff = 0;
        $tFinal = 0;
        $counts = explode(',', $order->stuffs_count);
        $desc = '';
        foreach ($products as $index => $pr) {
            $product = Product::where("unique_id", $pr['unique_id'])->firstOrFail();

            if ($order->user_phone != '09123456789' && $order->user_phone != '09182180519') {
                $product->sell = $product->sell + 1;
                $product->count = $product->count - 1;
            }
            if ($product->description)
                $desc .= $product->description . ',';
            else
                $desc .= '-,';

            $price_original += $product->price_original * $counts[$index];
//            $tPrice += $product->price * $counts[$index];
            $tOff += $product->price * $product->off / 100 * $counts[$index];
            $tFinal += ($product->price - ($product->price * $product->off / 100)) * $counts[$index];

            $product->save();
        }

        if ($tFinal < 35000) $tFinal += $send_price;
        $order->price = $tFinal;
        $order->price_original = $price_original;
        $order->stuffs_desc = ltrim(rtrim($desc, ','), ',');
        $order->temp = 1;
        $order->save();

        $this->addInfo($order);

        if ($method != 1) {
            $data = [
                "products" => $products,
                "counts" => $counts,
                "desc" => explode(',', $order->stuffs_desc),
                "user_name" => $order->user_name,
                "user_phone" => $order->user_phone,
                "user_code" => $user->code,
                "user_address" => $user->state . '-' . $user->city . ' : ' . $user->address,
                "total" => $tFinal + $tOff,
                "off" => $tOff,
                "final" => $tFinal,
                "hour" => $order->hour,
                "description" => $order->description,
                "date" => $order->create_date,
                "code" => $order->code,
                "send_price" => $send_price
            ];
            $pdf = PDF::loadView('pdf.factor', $data);
            $pdf->save(public_path('/ftp/factors/' . $order->code . '.pdf'));

            $type = "حضوری";

            SendEmail::dispatch([
                "to" => "hyper.online.h@gmail.com",
                "body" => "سفارش ( " . $type . " ) جدید ثبت شد",
                "order" => [
                    "code" => $order->code,
                    "user_name" => $order->user_name,
                    "user_phone" => $order->user_phone,
                    "stuffs" => $order->stuffs,
                    "hour" => $order->hour,
                    "price" => $order->price,
                    "desc" => $order->description,
                    "address" => $user->address
                ]
            ], 1)
                ->onQueue('email');

            if ($order->user_phone != '09182180519')
                SendSMS::dispatch([
                    "msg" => ["سفارش ( " . $type . " ) جدید ثبت شد"],
                    "phone" => ["09188167800"]
                ])
                    ->onQueue('sms');
        }

        return $order->unique_id;
    }

    public function addInfo(&$item)
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