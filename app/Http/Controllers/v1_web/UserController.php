<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Http\Controllers\v1_web;

use App\Category3;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use App\Services\v1\UserService;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $Users;

    /**
     * UserController constructor.
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->Users = $service;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if (Auth::guest())
            return view('welcome');
        else
            if (Auth::user()->Role() != "admin")
                return view('home');
            else
                return redirect()->route('admin');
    }

    public function profile()
    {

    }

    public function admin()
    {
        if (Auth::user()->Role() != "admin")
            return redirect()->route('profile');
        $title = "صفحه اصلی";
        $description = "خلاصه آمار";
        $category_count = count(Category3::get());
        $product_count = count(Product::get());
        $order_count = count(Order::get());
        $user_count = count(User::get());

        $days = [];
        $dates = [];
        $prices = [];
        $counts = [];
        $current_month = date('Y-m');

        for ($i = 1; $i <= 31; $i++) {
            $days[] = $i;
            // convert to 2 digit day
            if (strlen($i) == 1)
                $i = '0' . $i;
            $dates[] = $current_month . '-' . $i;
        }

        $orders = Order::orderBy("created_at", "desc")->get();

        foreach ($dates as $date) {
            $total = 0;
            $count = 0;
            foreach ($orders as $order) {
                $converted = explode(' ', $order->created_at)[0];
                if (!strcmp($date, $converted)) {
                    $total += intval($order->price);
                    $count++;
                }
            }
            $prices[] = strval($total);
            $counts[] = $count;
        }

        $priceChart = app()->chartjs
            ->name('prices')
            ->type('line')
            ->size(['width' => 1200, 'height' => 300])
            ->labels($days)
            ->datasets([
                [
                    "label" => "Total Price",
                    "backgroundColor" => "rgba(38,185,154,0.31)",
                    "borderColor" => "rgba(38,185,154,0.7)",
                    "pointBorderColor" => "rgba(38,185,154,0.7)",
                    "pointBackgroundColor" => "rgba(38,185,154,0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    "data" => $prices
                ]
            ])
            ->options([
                "fontFamily" => "Arial",
                "fontColor" => "#666"
            ]);

        $countChart = app()->chartjs
            ->name('counts')
            ->type('line')
            ->size(['width' => 1200, 'height' => 300])
            ->labels($days)
            ->datasets([
                [
                    "label" => "Total Count",
                    "backgroundColor" => "rgba(110,38,186,0.31)",
                    "borderColor" => "rgba(110,38,186,0.7)",
                    "pointBorderColor" => "rgba(110,38,186,0.7)",
                    "pointBackgroundColor" => "rgba(110,38,186,0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    "data" => $counts
                ]
            ])
            ->options([]);

        $users = User::orderBy("created_at", "desc")->take(5)->get();
        $orders = Order::orderBy("created_at", "desc")->take(5)->get();
        $products = Product::orderBy("created_at", "desc")->take(5)->get();

        //TODO: filter outputs
        //$users = $this->filterUser($users);
        //$orders = $this->filterOrder($orders);
        //$products = $this->filterProduct($products);

        return view('admin.dashboard', compact(
            'title',
            'description',
            'category_count',
            'product_count',
            'order_count',
            'user_count',
            'priceChart',
            'countChart',
            'users',
            'orders',
            'products'
        ));
    }

    protected function filterUser($users)
    {
//        $data = [];
        $data = array();
        foreach ($users as $user) {
            $entry = [
                'unique_id' => $user->unique_id,
                'name' => $user->name,
                'phone' => $user->phone,
                'address' => $user->address
            ];
//            $data[] = $entry;
            array_push($data, $entry);
        }
        return $data;
    }

    protected function filterOrder($orders)
    {
        $data = [];
        foreach ($orders as $order) {
            $entry = [
                'unique_id' => $order->unique_id,
                'code' => $order->code,
                'seller_name' => $order->seller_name,
                'seller_id' => $order->seller_id,
                'stuffs' => $order->stuffs,
                'price' => $this->formatMoney($order->price)
            ];
            $data[] = $entry;
        }
        return $data;
    }

    protected function filterProduct($products)
    {
        $data = [];
        foreach ($products as $product) {
            $entry = [
                'unique_id' => $product->unique_id,
                'name' => $product->name,
                'image' => $product->image,
                'description' => $product->description,
                'price' => $this->formatMoney($product->price),
                'count' => $product->count
            ];
            $data[] = $entry;
        }
        return $data;
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