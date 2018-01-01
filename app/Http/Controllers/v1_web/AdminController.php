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

use App\Author;
use App\Banner;
use App\Category1;
use App\Category2;
use App\Category3;
use App\Comment;
use App\Jobs\SendEmail;
use App\Option;
use App\Order;
use App\Product;
use App\Push;
use App\Seller;
use App\Sms;
use App\Support;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use phplusir\smsir\Smsir;
use Spatie\Analytics\Period;

require(app_path() . '/Common/jdf.php');

class AdminController
{
    public function index()
    {
        if (Auth::check())
            if (Auth::user()->isAdmin())
                return redirect()->route('admin');
            else
                return redirect()->route('home');
        else
            return redirect()->route('home');
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
        $orders = $this->fix(Order::where("status", "!=", "abort")->where("temp", 0)->orderBy("created_at", "desc")->take(5)->get());
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

    public function database_get()
    {
        $option = Option::firstOrFail();
        return view('admin.database')
            ->withTitle("Change Settings")
            ->withOption($option);
    }

    public function database_store(Request $request)
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

            SendEmail::dispatch([
                "to" => "hatamiarash7@gmail.com",
                "body" => $support->body,
                "title" => $support->section,
                "log" => $support->log
            ], 2);


            $message = "پیام شما ارسال شد";
            return redirect('/admin')
                ->withMessage($message);
        } else
            return redirect('/')
                ->withErrors('دسترسی غیرمجاز');
    }

    public function setting()
    {
        if (Auth::user()->isAdmin()) {
            $option = Option::first();
            return view('admin.setting')
                ->withTitle("تنظیمات")
                ->withOffline([
                    'off' => $option->offline,
                    'off_msg' => $option->offline_msg
                ]);
        } else
            return redirect('/')
                ->withErrors('دسترسی غیرمجاز');
    }

    public function setting_send(Request $request)
    {
        if (Auth::user()->isAdmin()) {
            $option = Option::first();

            $option->category = ($request->get('category') == "on") ? 1 : 0;
            $option->category_count = $request->get('category_count');
            $option->off = ($request->get('off') == "on") ? 1 : 0;
            $option->off_count = $request->get('off_count');
            $option->new = ($request->get('new') == "on") ? 1 : 0;
            $option->new_count = $request->get('new_count');
            $option->popular = ($request->get('popular') == "on") ? 1 : 0;
            $option->popular_count = $request->get('popular_count');
            $option->most_sell = ($request->get('most_sell') == "on") ? 1 : 0;
            $option->most_sell_count = $request->get('most_sell_count');
            $option->collection = ($request->get('collection') == "on") ? 1 : 0;
            $option->collection_count = $request->get('collection_count');
            $option->banner = ($request->get('banner') == "on") ? 1 : 0;
            $option->save();

            $message = "تنظیمات اعمال شد";
            return redirect('/admin/database')
                ->withMessage($message);
        } else
            return redirect('/')
                ->withErrors('دسترسی غیرمجاز');
    }

    public function delete_log()
    {
        unlink(storage_path('/logs/laravel.log'));
        return redirect('/admin/setting')
            ->withMessage("فایل لاگ پاک شد");
    }

    public function confirmAllPhones()
    {
        $users = User::where("confirmed_phone", 0)->get();
        foreach ($users as $user) {
            $user->confirmed_phone = 1;
            $user->save();
        }
        return redirect('/admin/setting')
            ->withMessage("تمام شماره ها تایید شد");
    }

    public function updateOffline(Request $request)
    {
        $option = Option::first();
        $option->offline = ($request->get('offline') == "on") ? 1 : 0;
        $option->offline_msg = $request->get('message');
        $option->save();
        return redirect('/admin/setting')
            ->withMessage("وضعیت فروشگاه تغییر کرد");
    }

    public function messages()
    {
        $sms = Sms::orderBy("created_at", "desc")->get();
        $push = Push::orderBy("created_at", "desc")->get();
        return view('admin.messages')
            ->withTitle("گزارشات پیام ها")
            ->withSms($sms)
            ->withPush($push);
    }

    public function messages_sms()
    {
        if (Auth::user()->isAdmin()) {
            return view('admin.messages_sms')
                ->withTitle("ارسال اس ام اس");
        } else
            return redirect('/')
                ->withErrors('دسترسی غیرمجاز');
    }

    public function messages_push()
    {
        if (Auth::user()->isAdmin()) {
            return view('admin.messages_push')
                ->withTitle("ارسال پوش");
        } else
            return redirect('/')
                ->withErrors('دسترسی غیرمجاز');
    }

    public function messages_send_sms(Request $request)
    {
        if (Auth::user()->isAdmin()) {
            $users = User::where("confirmed_phone", 1)->get();
            $phones = array();
            $messages = array();
            foreach ($users as $user) {
                array_push($phones, $user->phone);
                array_push($messages, $request->body);
            }
            Smsir::send($messages, $phones);

            $message = "پیام شما با موفقیت ارسال شد";
            return redirect('/admin/messages')
                ->withMessage($message);
        } else
            return redirect('/')
                ->withErrors('دسترسی غیرمجاز');
    }

    public function messages_send_push(Request $request)
    {
        $title = $request->get('title');
        $body = $request->get('body');

        $client = new Client([
            'headers' => [
                'Authorization' => 'Token 49a07ca7cb6a25c2d61044365c4560500a38ec3f',
                'Content-Type' => 'application/json',
                'Accept: application/json'
            ]
        ]);
        $response = $client->post(
            'https://panel.pushe.co/api/v1/notifications/',
            [
                'body' => json_encode([
                    "applications" => ["ir.hatamiarash.hyperonline"],
                    "notification" => [
                        "title" => $title,
                        "content" => $body
                    ]
                ])
            ]
        );
        if ($response->getStatusCode() == "201") {
            $message = "پیام شما با موفقیت ارسال شد";
            $push = new Push();
            $push->title = $title;
            $push->body = $body;
            $push->save();
            return redirect('/admin/messages')
                ->withMessage($message);
        } else {
            $message = "خطایی رخ داده است";
            return redirect('/admin/messages')
                ->withErrors($message);
        }
    }

    public function messages_send_confirm(Request $request)
    {
        $title = "تکمیل حساب";
        $body = $request->get('body');
        $id = $request->get('id');
        $user = User::where("unique_id", $id)->firstOrFail();

        if ($this->sendPush($user->pushe, $title, $body))
            return redirect('/admin/users/' . $id)
                ->withMessage("پیام شما با موفقیت ارسال شد");
        else
            return redirect('/admin/messages')
                ->withErrors("خطایی رخ داده است");
    }

    public function confirmInfo($id, $code)
    {
        $user = User::where("unique_id", $id)->firstOrFail();
        $user->confirmed_info = $code;
        $user->save();
        if ($code == 0) {
            $msg = "تاییدیه لغو شد";
        } else {
            $msg = "کاربر تایید شد";
            $this->sendPush($user->pushe, "اطلاعات حساب", "حساب شما تایید شد");
        }
        return redirect('/admin/users/' . $id)
            ->withMessage($msg);
    }

    public function search(Request $request)
    {
        $parameter = $request->get('parameter');
        $word = $request->get('word');

        if ($parameter == "products") {
            $products = Product::where("confirmed", 1)
                ->where('name', 'LIKE', '%' . $word . '%')
                ->orWhere('description', 'LIKE', '%' . $word . '%')
                ->get();
            $inactive = count(Product::where("confirmed", 0)
                ->get());

            Log::info("products\n" . $products);
            return view('admin.products')
                ->withTitle("جستجو - محصولات")
                ->withInactive($inactive)
                ->withProducts($this->fixPrice($products));
        } else if ($parameter == "category1") {
            $categories1 = Category1::where('name', 'LIKE', '%' . $word . '%')->get();
            $categories2 = Category2::where('name', "0")->get();
            $categories3 = Category3::where('name', "0")->get();
            return view('admin.categories')
                ->withTitle("جستجو - دسته بندی ها")
                ->withCategories1($categories1)
                ->withCategories2($categories2)
                ->withCategories3($categories3);
        } else if ($parameter == "category2") {
            $categories1 = Category1::where('name', "0")->get();
            $categories2 = Category2::where('name', 'LIKE', '%' . $word . '%')->get();
            $categories3 = Category3::where('name', "0")->get();
            return view('admin.categories')
                ->withTitle("جستجو - دسته بندی ها")
                ->withCategories1($categories1)
                ->withCategories2($categories2)
                ->withCategories3($categories3);
        } else if ($parameter == "category3") {
            $categories1 = Category1::where('name', "0")->get();
            $categories2 = Category2::where('name', "0")->get();
            $categories3 = Category3::where('name', 'LIKE', '%' . $word . '%')->get();
            return view('admin.categories')
                ->withTitle("جستجو - دسته بندی ها")
                ->withCategories1($categories1)
                ->withCategories2($categories2)
                ->withCategories3($categories3);
        } else if ($parameter == "users") {
            $users = User::where('name', 'LIKE', '%' . $word . '%')
                ->orWhere('phone', 'LIKE', '%' . $word . '%')
                ->get();
            return view('admin.users')
                ->withTitle("جستجو - کاربران")
                ->withUsers($users);
        } else if ($parameter == "orders") {
            $orders = Order::where('user_name', 'LIKE', '%' . $word . '%')
                ->orWhere('stuffs', 'LIKE', '%' . $word . '%')
                ->orWhere('code', 'LIKE', '%' . $word . '%')
                ->get();
            return view('admin.orders')
                ->withTitle("جستجو - سفارشات")
                ->withOrders($this->fixPrice($orders));
        } else if ($parameter == "comments") {
        } else if ($parameter == "authors") {
            $authors = Author::where('name', 'LIKE', '%' . $word . '%')
                ->orWhere('phone', 'LIKE', '%' . $word . '%')
                ->get();

            return view('admin.authors')
                ->withTitle("جستجو - فروشنده ها")
                ->withAuthors($authors);
        } else if ($parameter == "sellers") {
            $sellers = Seller::where('name', 'LIKE', '%' . $word . '%')
                ->orWhere('phone', 'LIKE', '%' . $word . '%')
                ->get();
            return view('admin.sellers')
                ->withTitle("جستجو - فروشگاه ها")
                ->withSellers($sellers);
        } else {
            $message = "خطایی رخ داده است";
            return back()
                ->withErrors($message);
        }
        return back()
            ->withErrors("خطایی رخ داده است");
    }

    public function accounting()
    {
        $orders = Order::get();
        $total_price = $total_price_original = $total_send = $total_count = 0;
        $total_order = $total_abort = $total_pending = $total_delivered = $total_shipped = 0;

        foreach ($orders as $order) {
            if ($order->status != "abort") {
                $total_price += $order->price;
                $total_price_original += $order->price_original;
                $total_send += $order->price_send;
//                $order->stuffs_count = rtrim($order->stuffs_count, ',');
                $count = explode(',', ltrim(rtrim($order->stuffs_count, ','), ','));
                foreach ($count as $i)
                    $total_count += $i;
                if ($order->status == "pending") $total_pending += 1;
                elseif ($order->status == "shipped") $total_shipped += 1;
                elseif ($order->status == "delivered") $total_delivered += 1;
            } else
                $total_abort += 1;
            $total_order += 1;
        }

        $prices = [
            'TotalPrice' => $this->formatMoney($total_price),
            'TotalOriginal' => $this->formatMoney($total_price_original),
            'TotalSend' => $this->formatMoney($total_send),
            'TotalBenefit' => $this->formatMoney($total_price - $total_price_original),
        ];

        $status = [
            'delivered' => $total_delivered,
            'shipped' => $total_shipped,
            'pending' => $total_pending,
            'abort' => $total_abort,
            'total' => $total_order
        ];

        return view('admin.accounting')
            ->withTitle("حسابداری")
            ->withPrices($prices)
            ->withStatus($status)
            ->withCount($total_count);
    }

    public function banner_show()
    {
        if (Auth::user()->isAdmin()) {
            return view('admin.banner_create')
                ->withTitle("بنر جدید");
        } else
            return redirect('/')
                ->withErrors('دسترسی غیرمجاز');
    }

    public function banner_create(Request $request)
    {
        $banner = new Banner();
        $uid = uniqid('', false);
        $banner->unique_id = $uid;
        $banner->title = $request->get('title');
        $banner->link = $request->get('link');
        $banner->size = 0;
        $banner->type = $request->get('type');

        if (Input::hasFile('image')) {
            $image = $request->file('image');
            $input['imagename'] = 'B.' . $uid . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images');
            $image->move($destinationPath, $input['imagename']);
            $banner->image = $input['imagename'];
        }

        $banner->save();

        $message = "بنر اضافه شد";
        return redirect('/admin/banners')->withMessage($message);
    }

    public function banners()
    {
        if (Auth::user()->isAdmin()) {
            $banners = Banner::where("type", 0)->get();
            return view('admin.banners')
                ->withBanners($banners)
                ->withTitle("بنر ها");
        } else
            return redirect('/')
                ->withErrors('دسترسی غیرمجاز');
    }

    public function banner_edit($id)
    {
        $banner = Banner::where("unique_id", $id)->firstOrFail();
        return view('admin.banner_edit')
            ->withTitle("ویرایش بنر")
            ->withBanner($banner);
    }

    public function banner_update(Request $request)
    {
        if (Auth::user()->isAdmin()) {
            $id = $request->get("unique_id");
            $banner = Banner::where("unique_id", $id)->firstOrFail();
            $banner->title = $request->get("title");
            $banner->link = $request->get("link");

            if (Input::hasFile('image')) {
                // first delete old one
                File::delete('images/' . $banner->image);
                $image = $request->file('image');
                $input['imagename'] = 'B.' . $banner->unique_id . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('images');
                $image->move($destinationPath, $input['imagename']);
                $banner->image = $input['imagename'];
            }

            $banner->save();
            $message = "بنر به روزرسانی شد";
            return redirect('/admin/banners')
                ->withMessage($message);
        } else
            return redirect('/')
                ->withErrors('دسترسی غیرمجاز');
    }

    public function banner_delete($id)
    {
        if (Auth::user()->isAdmin()) {
            $banner = Banner::find($id);
            if ($banner->image)
                File::delete('images/' . $banner->image);
            $banner->delete();
            $message = "بنر حذف شد";
            return redirect('/admin/banners')
                ->withMessage($message);
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

    protected function fix($items)
    {
        foreach ($items as $item)
            $this->addCount($item);
        return $this->fixPrice($items);
    }

    protected function addCount(&$item)
    {
        $stuff = explode(',', ltrim(rtrim($item->stuffs, ','), ','));
        $stuff_count = explode(',', ltrim(rtrim($item->stuffs_count, ','), ','));
        $final = "";
        foreach (array_values($stuff) as $i => $value) {
            $final .= $value . ' ( ' . $stuff_count[$i] . ' عدد ) - ';
        }
        $item->stuffs = substr($final, 0, -3);
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

    protected function sendPush($id, $title, $body)
    {
        $client = new Client([
            'headers' => [
                'Authorization' => 'Token 49a07ca7cb6a25c2d61044365c4560500a38ec3f',
                'Content-Type' => 'application/json',
                'Accept: application/json'
            ]
        ]);
        $response = $client->post(
            'https://panel.pushe.co/api/v1/notifications/',
            [
                'body' => json_encode([
                    "applications" => ["ir.hatamiarash.hyperonline"],
                    "filter" => [
                        "imei" => [$id]
                    ],
                    "notification" => [
                        "title" => $title,
                        "content" => "۱ پیام جدید دریافت شد",
                        "wake_screen" => true,
                        "action" => [
                            "action_data" => "Activity_Inbox",
                            "action_type" => "T"
                        ],
                    ],
                    "custom_content" => [
                        "type" => "1",
                        "msg" => [
                            "title" => $title,
                            "body" => $body,
                            "date" => $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime())
                        ]
                    ]
                ])
            ]
        );
        if ($response->getStatusCode() == "201") {
            $push = new Push();
            $push->title = $title;
            $push->body = $body;
            $push->save();

            return true;
        } else
            return false;
    }

    public function resetMostSell()
    {
        $products = Product::get();
        foreach ($products as $product) {
            $product->sell = 0;
            $product->save();
        }
        $message = "فروش محصولات به حالت صفر برگشت";
        return redirect('/admin/setting')
            ->withMessage($message);
    }

    public function popUser($uid)
    {
        $user = User::where("unique_id", $uid)->first();
        $id = $user->pushe;
        $client = new Client([
            'headers' => [
                'Authorization' => 'Token 49a07ca7cb6a25c2d61044365c4560500a38ec3f',
                'Content-Type' => 'application/json',
                'Accept: application/json'
            ]
        ]);
        $response = $client->post(
            'https://panel.pushe.co/api/v1/notifications/',
            [
                'body' => json_encode([
                    "applications" => ["ir.hatamiarash.hyperonline"],
                    "filter" => [
                        "imei" => [$id]
                    ],
                    "notification" => [
                        "wake_screen" => true,
                    ],
                    "custom_content" => [
                        "type" => "2",
                        "logout" => [
                            "out" => true,
                        ]
                    ]
                ])
            ]
        );
        if ($response->getStatusCode() == "201") {
            return redirect('/admin/users/' . $uid)
                ->withMessage("کاربر خارج شد");
        } else
            return redirect('/admin/users/' . $uid)
                ->withErrors("خطایی رخ داده است");
    }

    public function comments()
    {
        $comments = Comment::orderBy("created_at", "desc")->get();
        return view('admin.comments')
            ->withTitle("نظرات")
            ->withComments($comments);
    }

    public function analytics(){
        $analyticsData = Analytics::fetchVisitorsAndPageViews(Period::days(7));
        return view('admin.analytics')
            ->withTitle("Analytics")
            ->withData($analyticsData);
    }
}