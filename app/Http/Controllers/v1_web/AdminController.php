<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

/**
 * Created by PhpStorm.
 * User: root
 * Date: 8/14/17
 * Time: 6:19 PM
 */

namespace app\Http\Controllers\v1_web;

use App\Category3;
use App\Option;
use App\Order;
use App\Product;
use App\Support;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminController
{
    public function index()
    {
        if (Auth::guest())
            return view('welcome');
        else
            if (!Auth::user()->isAdmin())
                return view('home');
            else
                return redirect()->route('admin');
    }

    public function admin()
    {
        if (!Auth::user()->isAdmin())
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
        $orders = $this->fixPrice(Order::orderBy("created_at", "desc")->take(5)->get());
        $products = $this->fixPrice(Product::orderBy("created_at", "desc")->take(5)->get());

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

    public function settings_get()
    {
        $option = Option::firstOrFail();
        return view('admin.settings')
            ->withTitle("Change Settings")
            ->withOption($option);
    }

    public function settings_store(Request $request)
    {
        if (Auth::user()->isAdmin()) {
            $option = Option::where("unique_id", $request->get('unique_id'))->firstOrFail();

            $category = 0;
            $off = 0;
            $new = 0;
            $most_sell = 0;
            $popular = 0;
            $collection = 0;
            if ($request->get('category') == "on") $category = 1;
            if ($request->get('off') == "on") $off = 1;
            if ($request->get('new') == "on") $new = 1;
            if ($request->get('most_sell') == "on") $most_sell = 1;
            if ($request->get('popular') == "on") $popular = 1;
            if ($request->get('collection') == "on") $collection = 1;

            $option->category = $category;
            $option->category_count = $request->get('category_count');
            $option->off = $off;
            $option->off_count = $request->get('off_count');
            $option->new = $new;
            $option->new_count = $request->get('new_count');
            $option->popular = $popular;
            $option->popular_count = $request->get('popular_count');
            $option->most_sell = $most_sell;
            $option->most_sell_count = $request->get('most_sell_count');
            $option->collection = $collection;
            $option->collection_count = $request->get('collection_count');

            $option->save();
            $message = "options updated";
            return redirect('/admin')
                ->withMessage($message);
        } else
            return redirect('/')
                ->withErrors('دسترسی غیرمجاز');
    }

    public function support()
    {
        if (Auth::user()->isAdmin()) {
            return view('admin.support')
                ->withTitle("Support");
        } else
            return redirect('/')
                ->withErrors('دسترسی غیرمجاز');
    }

    public function support_send(Request $request)
    {
        if (Auth::user()->isAdmin()) {
            $support = new Support();
            $support->unique_id = uniqid('', false);
            $support->section = $request->get('section');
            $support->body = $request->get('body');
            if ($request->get('log') == 'on')
                $support->log = 1;
            else
                $support->log = 0;
            $support->save();

            Mail::to("hatamiarash7@gmail.com")
                ->send(new \App\Mail\Support($support));
        } else
            return redirect('/')
                ->withErrors('دسترسی غیرمجاز');
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