<?php

namespace App\Http\Controllers\v1\market;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use App\Order;
use App\Pay;
use App\Product;
use App\Seller;
use App\Services\v1\market\MainService;
use App\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

require(app_path() . '/Common/jdf.php');

class MainController extends Controller
{
    protected $mService;

    public function __construct(MainService $service)
    {
        $this->mService = $service;
    }

    public function index()
    {
        $new = $this->mService->getNew();
        $cat = $this->mService->getCategories();

        $cart = [
            'items' => Cart::content(),
            'count' => Cart::content()->count(),
            'total' => Cart::total(),
            'tax' => Cart::tax(),
            'subtotal' => Cart::subtotal()
        ];

        $isAdmin = 0;

        if (Auth::check())
            if (Auth::user()->isAdmin() == 1)
                $isAdmin = 1;

        $most = $this->mService->getMostSell();

        $cat1 = $this->mService->getRandomCategory();
        $cat2 = $this->mService->getRandomCategory();
        $cat3 = $this->mService->getRandomCategory2();
        $off = $this->mService->getOff();

        return view('market.home')
            ->withNew($new)
            ->withCategories($cat)
            ->withCart($cart)
            ->withMost($most)
            ->withRand1($cat1)
            ->withRand2($cat2)
            ->withRand3($cat3)
            ->withOff($off)
            ->withAdmin($isAdmin);
    }

    public function checkout()
    {
        $isAdmin = 0;

        if (Auth::check())
            if (Auth::user()->isAdmin() == 1)
                $isAdmin = 1;

        $cat = $this->mService->getCategories();

        $cart = [
            'items' => Cart::content(),
            'count' => Cart::content()->count(),
            'total' => Cart::total(),
            'tax' => Cart::tax(),
            'subtotal' => Cart::subtotal()
        ];
        return view('market.checkout')
            ->withCategories($cat)
            ->withAdmin($isAdmin)
            ->withCart($cart);
    }

    public function pay()
    {
        $client = new Client();
        $res = $client->request(
            'POST',
            'https://pay.ir/payment/send',
            [
                'json' => [
                    'api' => '4d0d3be84eae7fbe5c317bf318c77e83',
                    'amount' => '1000',
                    'redirect' => "http://hyper-online.ir/callback",
                    'factorNumber' => '1'
                ]
            ]);
        $transId = json_decode($res->getBody(), true)['transId'];
        return redirect('https://pay.ir/payment/gateway/' . $transId);
    }

    public function callback(Request $request)
    {
        $pay = new Pay();
        if (app('request')->exists('status')) $pay->status = $request->input('status');
        if (app('request')->exists('transId')) $pay->transId = $request->input('transId');
        if (app('request')->exists('factorNumber')) $pay->factorNumber = $request->input('factorNumber');
        if (app('request')->exists('cardNumber')) $pay->cardNumber = $request->input('cardNumber');
        if (app('request')->exists('message')) $pay->message = $request->input('message');
        $pay->save();

        $cat = $this->mService->getCategories();

        $client = new Client();
        $res = $client->request(
            'POST',
            'https://pay.ir/payment/verify',
            [
                'json' => [
                    'api' => '4d0d3be84eae7fbe5c317bf318c77e83',
                    'transId' => $pay->transId
                ]
            ]);
        $status = json_decode($res->getBody(), true)['status'];

        if ($status == 1) {
            $this->setOrder($pay->transId);
            $result = "پرداخت انجام شد";
        } else
            $result = "مشکلی رخ داده است";

        $cart = [
            'items' => Cart::content(),
            'count' => Cart::content()->count(),
            'total' => Cart::total(),
            'tax' => Cart::tax(),
            'subtotal' => Cart::subtotal()
        ];

        $isAdmin = 0;

        if (Auth::check())
            if (Auth::user()->isAdmin() == 1)
                $isAdmin = 1;

        return view('market.report')
            ->withCategories($cat)
            ->withCart($cart)
            ->withAdmin($isAdmin)
            ->withResult($result);
    }

    protected function setOrder($code)
    {
        $content = Cart::content();
        $total = Cart::total();
        $user = User::where('unique_id', Auth::user()->unique_id)->firstOrFail();
        $seller = Seller::firstOrFail();

        $stuffs = "";
        $stuffs_id = "";
        $stuffs_count = "";
        foreach ($content as $item) {
            $stuffs .= ',' . $item->name;
            $stuffs_id .= ',' . $item->id;
            $stuffs_count .= ',' . $item->qty;
        }


        $order = new Order();
        $order->unique_id = uniqid('', false);
        $order->seller_id = $seller->unique_id;
        $order->user_id = $user->unique_id;
        $order->code = $code;
        $order->seller_name = $seller->name;
        $order->user_name = $user->name;
        $order->user_phone = $user->phone;
        $order->stuffs = ltrim(rtrim($stuffs, ','), ',');
        $order->stuffs_id = ltrim(rtrim($stuffs_id, ','), ',');
        $order->stuffs_count = ltrim(rtrim($stuffs_count, ','), ',');
        $order->price_send = 5000;
        $order->hour = $this->calcTime();
        $order->pay_method = 'online';
        $order->description = "";
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

        Cart::destroy();
    }

    protected function calcTime()
    {
        $hour = date("H", time());
        $minute = date("m", time());
        $send_time = 0;

        if ($hour >= 9 && $hour < 10)
            if ($minute <= 40)
                $send_time = 9;
            else
                $send_time = 11;
        if ($hour >= 10 && $hour < 11) $send_time = 2;
        if ($hour >= 11 && $hour < 12)
            if ($minute <= 40)
                $send_time = 11;
            else
                $send_time = 16;
        if ($hour >= 12 && $hour < 16) $send_time = 3;
        if ($hour >= 16 && $hour < 17)
            if ($minute <= 40)
                $send_time = 16;
            else
                $send_time = 18;
        if ($hour >= 17 && $hour < 18) $send_time = 4;
        if ($hour >= 18 && $hour < 19)
            if ($minute <= 40)
                $send_time = 18;
            else
                $send_time = 9;
        if ($hour >= 19 && $hour <= 23) $send_time = 9;
        if ($hour >= 0 && $hour < 9) $send_time = 9;
        return $send_time;
    }

    public function contact_us()
    {
        $isAdmin = 0;
        if (Auth::check())
            if (Auth::user()->isAdmin() == 1)
                $isAdmin = 1;
        $cat = $this->mService->getCategories();
        $cart = [
            'items' => Cart::content(),
            'count' => Cart::content()->count(),
            'total' => Cart::total(),
            'tax' => Cart::tax(),
            'subtotal' => Cart::subtotal()
        ];
        return view('market.contact_us')
            ->withCategories($cat)
            ->withAdmin($isAdmin)
            ->withCart($cart);
    }

    public function about()
    {
        $isAdmin = 0;
        if (Auth::check())
            if (Auth::user()->isAdmin() == 1)
                $isAdmin = 1;
        $cat = $this->mService->getCategories();
        $cart = [
            'items' => Cart::content(),
            'count' => Cart::content()->count(),
            'total' => Cart::total(),
            'tax' => Cart::tax(),
            'subtotal' => Cart::subtotal()
        ];
        return view('market.about')
            ->withCategories($cat)
            ->withAdmin($isAdmin)
            ->withCart($cart);
    }

    public function privacy()
    {
        $isAdmin = 0;
        if (Auth::check())
            if (Auth::user()->isAdmin() == 1)
                $isAdmin = 1;
        $cat = $this->mService->getCategories();
        $cart = [
            'items' => Cart::content(),
            'count' => Cart::content()->count(),
            'total' => Cart::total(),
            'tax' => Cart::tax(),
            'subtotal' => Cart::subtotal()
        ];
        return view('market.privacy')
            ->withCategories($cat)
            ->withAdmin($isAdmin)
            ->withCart($cart);
    }

    public function terms()
    {
        $isAdmin = 0;
        if (Auth::check())
            if (Auth::user()->isAdmin() == 1)
                $isAdmin = 1;
        $cat = $this->mService->getCategories();
        $cart = [
            'items' => Cart::content(),
            'count' => Cart::content()->count(),
            'total' => Cart::total(),
            'tax' => Cart::tax(),
            'subtotal' => Cart::subtotal()
        ];
        return view('market.terms')
            ->withCategories($cat)
            ->withAdmin($isAdmin)
            ->withCart($cart);
    }

    public function comment()
    {
        $isAdmin = 0;
        if (Auth::check())
            if (Auth::user()->isAdmin() == 1)
                $isAdmin = 1;
        $cat = $this->mService->getCategories();
        $cart = [
            'items' => Cart::content(),
            'count' => Cart::content()->count(),
            'total' => Cart::total(),
            'tax' => Cart::tax(),
            'subtotal' => Cart::subtotal()
        ];
        return view('market.comment')
            ->withCategories($cat)
            ->withAdmin($isAdmin)
            ->withCart($cart);
    }

    public function sendComment(Request $request)
    {
        $comment = new Comment();
        $comment->unique_id = uniqid('', false);
        if (Auth::check())
            $user = User::find(Auth::user()->getID());
        else
            $user = User::where("role", "admin")->first();
        $comment->user_id = $user->unique_id;
        $comment->user_name = $user->name;
        if ($user->image)
            $comment->user_image = $user->image;
        $comment->body = $request->get('body');
        $comment->create_date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());
        $comment->save();
        SendEmail::dispatch([
            "to" => "hyper.online.h@gmail.com",
            "body" => "نظر جدید در سایت ثبت شد"
        ], 0)
            ->onQueue('email');
        return redirect('/');
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