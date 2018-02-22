<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use App\Seller;
use App\Services\v1\MainService;
use App\User;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phplusir\smsir\Smsir;

class MainController extends Controller
{
    protected $Main;

    /**
     * UserController constructor.
     * @param MainService $service
     */
    public function __construct(MainService $service)
    {
        $this->Main = $service;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $new = $this->Main->getNew();
            $popular = $this->Main->getPopular();
            $category = $this->Main->getCategories();
            $options = $this->Main->getOptions();
            $most = $this->Main->getMostSell();
            $off = $this->Main->getOffs();
            $collection = $this->Main->getCollections();
            $send_price = $this->Main->getSendPrice();
            $banners = $this->Main->getBanners();
            $offline = $this->Main->getOffline();
            if (1)
                return response()->json([
                    'error' => false,
                    'send_price' => $send_price,
                    'banner' => $banners,
                    'new' => $new,
                    'popular' => $popular,
                    'category' => $category,
                    'options' => $options,
                    'most' => $most,
                    'off' => $off,
                    'collection' => $collection,
                    'status' => [
                        'offline_S' => $offline['off'],
                        'offline' => $offline['off_msg']
                    ]
                ], 201);
            else
                return response()->json([
                    'error' => true,
                    'error_msg' => "something's wrong"
                ], 201);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'error_msg' => $e->getMessage()
            ], 201);
        }
    }

    public function search(Request $request)
    {
        try {
            $result = $this->Main->Search($request);
            if ($result != 0)
                return response()->json([
                    'error' => false,
                    'result' => $result
                ], 201);
            elseif ($result == 0)
                return response()->json([
                    'error' => true,
                    'error_msg' => "محصول مورد نظر یافت نشد"
                ], 201);
            else
                return response()->json([
                    'error' => true,
                    'error_msg' => "something's wrong"
                ], 201);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'error_msg' => $e->getMessage()
            ], 201);
        }
    }

    public function downloadLink(Request $request)
    {
        $user = $request->get('from');
        $message = "دانلود هایپرآنلاین" . "\n" . "http://hyper-online.ir/HyperOnline.apk";
        Smsir::send([$message], [$user]);
    }

    public function armin()
    {
        $products = Product::orderBy("sell", "desc")->get();
        return view('armin')->withProducts($products);
    }

    public function test()
    {
        $seller = Seller::where('unique_id', "vbkYwlL98I3F3")->firstOrFail();
        if (Cart::content()->count() > 0)
            $send_price = $seller->send_price;
        else
            $send_price = 0;
        $isAdmin = 0;

        if ((int)str_replace(',', '', Cart::subtotal()) > 30000) {
            $send_price = 0;
            $free_ship = true;
        } else
            $free_ship = false;

        if (Auth::check())
            if (Auth::user()->isAdmin() == 1)
                $isAdmin = 1;

        $mService = new MainService();

        $cat = $mService->getCategories();

        $cart = [
            'items' => Cart::content(),
            'count' => Cart::content()->count(),
            'total' => number_format((int)str_replace(',', '', Cart::subtotal()) + $send_price),
            'tax' => number_format($send_price),
            'subtotal' => Cart::subtotal(),
            'free-ship' => $free_ship
        ];

        $order = Order::first();

        $ids = explode(',', $order->stuffs_id);
        $products = array();
        foreach ($ids as $id) {
            $p = Product::where("unique_id", $id)->firstOrFail()->toArray();
            array_push($products, $p);
        }

        $counts = explode(',', $order->stuffs_count);

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

        return view('market.result')
            ->withData($data)
            ->withOrder($order)
            ->withCategories($cat)
            ->withAdmin($isAdmin)
            ->withCart($cart);
    }
}
