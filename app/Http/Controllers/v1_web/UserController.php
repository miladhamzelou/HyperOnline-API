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
            return view('home');
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
            foreach ($orders as $order) {
                $converted = explode(' ', $order->created_at)[0];
                if (!strcmp($date, $converted))
                    $total += intval($order->price);
            }
            $prices[] = strval($total);
        }

        $chart = app()->chartjs
            ->name('test')
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
            ->options([]);
        return view('admin.dashboard', compact(
            'title',
            'description',
            'category_count',
            'product_count',
            'order_count',
            'user_count',
            'chart'
        ));
    }
}