<?php

namespace App\Http\Controllers\v1\market;

use App\Http\Controllers\Controller;
use App\Pay;
use App\Services\v1\market\MainService;
use Gloudemans\Shoppingcart\Facades\Cart;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

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

        if (Auth::check())
            $isAdmin = Auth::user()->isAdmin() ? 1 : 0;
        else
            $isAdmin = 0;

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
            Cart::destroy();
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

        return view('market.report')
            ->withCategories($cat)
            ->withCart($cart)
            ->withResult($result);
    }
}