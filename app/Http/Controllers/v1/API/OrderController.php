<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use App\Jobs\SendSMS;
use App\Order;
use App\Pay;
use App\Product;
use App\Seller;
use App\Services\v1\MainService;
use App\Services\v1\OrderService;
use App\User;
use DateTime;
use DateTimeZone;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class OrderController extends Controller
{
    protected $Orders;
    protected $API;

    /**
     * ProductController constructor.
     * @param OrderService $service
     */
    public function __construct(OrderService $service)
    {
        if (!function_exists("jalali_to_gregorian"))
            require_once(app_path() . '/Common/jdf.php');
        require(app_path() . '/Common/MYPDF.php');
        $this->Orders = $service;
        $this->API = "4d0d3be84eae7fbe5c317bf318c77e83";
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
    }

    public function store(Request $request)
    {
        try {
            $result = $this->Orders->createOrder($request);
            if ($result)
                return response()->json([
                    'error' => false
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

    public function storeTemp(Request $request)
    {
        try {
            $result = $this->Orders->tempOrder($request);
            if ($result)
                return response()->json([
                    'error' => false,
                    'code' => $result
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

    public function userOrders(Request $request)
    {
        try {
            $result = $this->Orders->userOrders($request);
            if ($result)
                return response()->json([
                    'error' => false,
					'orders' => $result
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

    public function pay($id)
    {
        $order = Order::where("unique_id", $id)->first();
        if ($order) {
            $client = new Client([
                'headers' => ['Content-Type' => 'application/json']
            ]);
            $url = "https://pay.ir/payment/send";
            $params = [
                'api' => $this->API,
                'amount' => $order->price * 10,
//                'amount' => 1000,
                'redirect' => "http://hyper-online.ir/callback2",
                'mobile' => $order->user_phone,
                'factorNumber' => $id,
            ];
            $response = $client->post(
                $url,
                ['body' => json_encode($params)]
            );

            $response = (array)json_decode($response->getBody()->getContents());

            if ($response['status'] == 1) {
                $transId = $response['transId'];
                $order->transId = $transId;
                $order->save();
                return Redirect::to("http://pay.ir/payment/gateway/" . $transId);
            } else {
                return response()->json([
                    'error' => true,
                    'error_msg' => $response['errorCode']
                ], 201);
            }
        } else {
            return "session expired";
        }
    }

    public function pay_test($price)
    {
        $client = new Client([
            'headers' => ['Content-Type' => 'application/json']
        ]);
        $url = "https://pay.ir/payment/send";
        $params = [
            'api' => $this->API,
            'amount' => $price,
            'redirect' => "http://hyper-online.ir/callback2",
            'mobile' => '09182180519',
            'factorNumber' => '1',
        ];
        $response = $client->post(
            $url,
            ['body' => json_encode($params)]
        );

        $response = (array)json_decode($response->getBody()->getContents());

        if ($response['status'] == 1) {
            $transId = $response['transId'];
            return Redirect::to("http://pay.ir/payment/gateway/" . $transId);
        } else {
            return response()->json([
                'error' => true,
                'error_msg' => $response['errorCode']
            ], 201);
        }
    }

    public function call_back(Request $request)
    {
        $pay = new Pay();
        if (app('request')->exists('status')) $pay->status = $request->input('status');
        if (app('request')->exists('transId')) $pay->transId = $request->input('transId');
        if (app('request')->exists('factorNumber')) $pay->factorNumber = $request->input('factorNumber');
        if (app('request')->exists('cardNumber')) $pay->cardNumber = $request->input('cardNumber');
        if (app('request')->exists('message')) $pay->message = $request->input('message');
        $pay->save();

        $res = $this->verify($this->API, $pay->transId);
        $res = (array)json_decode($res);

        if ($res['status'] == 1) {
            header("location: hyper://pay?error=0&code=" . $pay->factorNumber);
        } else {
            header("location: hyper://pay?error=1&er_code=" . $res['errorCode']);
        }
        exit();
    }

    private function verify($api, $transId)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://pay.ir/payment/verify');
        curl_setopt($ch, CURLOPT_POSTFIELDS, "api=$api&transId=$transId");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }

    public function completeOrder(Request $request)
    {
        $id = $request->get('id');
        $order = Order::where("unique_id", $id)->first();
        if ($order->temp == 1) {
            $order->temp = 0;
            $order->save();
            $user = User::where('unique_id', $order->user_id)->firstOrFail();
            $seller = Seller::where('unique_id', "vbkYwlL98I3F3")->firstOrFail();
            $send_price = $seller->send_price;

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
                if ($product->description)
                    $desc .= $product->description . ',';
                else
                    $desc .= '-,';
                $price_original += $product->price_original * $counts[$index];
                $tPrice += $product->price * $counts[$index];
                $tOff += $product->price * $product->off / 100 * $counts[$index];
                $tFinal += ($product->price - ($product->price * $product->off / 100)) * $counts[$index];
            }

            if ($tFinal >= 30000) $send_price = 0;

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

            $type = "";
            if ($order->pay_method == 'online') $type = "آنلاین";
            else if ($order->pay_method == 'place') $type = "حضوری";

            $this->addInfo($order);

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
                    "address" => $data["user_address"]
                ]
            ], 1)
                ->onQueue('email');

            if ($order->user_phone != '09182180519')
                SendSMS::dispatch([
                    "msg" => ["سفارش ( " . $type . " ) جدید ثبت شد"],
                    "phone" => ["09188167800"]
                ])
                    ->onQueue('sms');

            return response()->json([
                'error' => false
            ], 201);
        } else {
            return response()->json([
                'error' => true,
                'error_msg' => 'این سفارش قبلا ثبت شده است'
            ], 201);
        }
    }

    public function web_pay()
    {
        $items = Cart::content();

        $stuffs = "";
        $stuffs_id = "";
        $stuffs_count = "";

        foreach ($items as $item) {
            $stuffs .= $item->name;
            $stuffs_id .= $item->id;
            $stuffs_count .= $item->qty;
        }

        $order = new Order();
        $user = Auth::user();
        $seller = Seller::where('unique_id', "vbkYwlL98I3F3")->firstOrFail();
        $send_price = $seller->send_price;

        $order->unique_id = uniqid('', false);
        $order->seller_id = $seller->unique_id;
        $order->user_id = $user->unique_id;
        $order->code = $order->unique_id;
        $order->seller_name = $seller->name;
        $order->user_name = $user->name;
        $order->user_phone = $user->phone;
        $order->stuffs = ltrim(rtrim($stuffs, ','), ',');
        $order->stuffs_id = ltrim(rtrim($stuffs_id, ','), ',');
        $order->stuffs_count = ltrim(rtrim($stuffs_count, ','), ',');
        $order->price_send = $send_price;
        $order->hour = $this->getOrderHour();
        $order->pay_method = 'online';
        $order->create_date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());

        $ids = explode(',', $order->stuffs_id);
        $products = array();
        foreach ($ids as $id) {
            $p = Product::where("unique_id", $id)->firstOrFail()->toArray();
            array_push($products, $p);
        }
        $price_original = 0;
        $tOff = 0;
        $tFinal = 0;
        $counts = explode(',', $order->stuffs_count);
        $desc = '';
        foreach ($products as $index => $pr) {
            $product = Product::where("unique_id", $pr['unique_id'])->firstOrFail();

            if ($order->user_phone != '09123456789' && $order->user_phone != '09182180519' && $order->user_phone != '09182180520') {
                $product->sell = $product->sell + 1;
                $product->count = $product->count - 1;
            }
            if ($product->description)
                $desc .= $product->description . ',';
            else
                $desc .= '-,';

            $price_original += $product->price_original * $counts[$index];
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

        $client = new Client([
            'headers' => ['Content-Type' => 'application/json']
        ]);
        $url = "https://pay.ir/payment/send";
        $params = [
            'api' => $this->API,
            'amount' => $order->price * 10,
            'redirect' => "http://hyper-online.ir/callback3",
            'mobile' => $order->user_phone,
            'factorNumber' => $order->unique_id,
        ];
        $response = $client->post(
            $url,
            ['body' => json_encode($params)]
        );

        $response = (array)json_decode($response->getBody()->getContents());

        if ($response['status'] == 1) {
            $transId = $response['transId'];
            $order->transId = $transId;
            $order->save();
            return Redirect::to("http://pay.ir/payment/gateway/" . $transId);
        } else {
            return response()->json([
                'error' => true,
                'error_msg' => $response['errorCode']
            ], 201);
        }
    }

    public function call_back2(Request $request)
    {
        $pay = new Pay();
        if (app('request')->exists('status')) $pay->status = $request->input('status');
        if (app('request')->exists('transId')) $pay->transId = $request->input('transId');
        if (app('request')->exists('factorNumber')) $pay->factorNumber = $request->input('factorNumber');
        if (app('request')->exists('cardNumber')) $pay->cardNumber = $request->input('cardNumber');
        if (app('request')->exists('message')) $pay->message = $request->input('message');
        $pay->save();

        $res = $this->verify($this->API, $pay->transId);
        $res = (array)json_decode($res);

        if ($res['status'] == 1) {
            $order = Order::where("unique_id", $pay->factorNumber)->firstOrFail();
            if ($this->completeOrder2($pay->factorNumber)) {
                Cart::destroy();
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
            } else
                return view('market.result')->withError("مشکلی به وجود آمده است");
        } else {
            return view('market.result')->withError($res['errorCode']);
        }
    }

    public function completeOrder2($o_id)
    {
        $order = Order::where("unique_id", $o_id)->first();
        if ($order->temp == 1) {
            $order->temp = 0;
            $user = User::where('unique_id', $order->user_id)->firstOrFail();
            $seller = Seller::where('unique_id', "vbkYwlL98I3F3")->firstOrFail();
            $send_price = $seller->send_price;

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
                if ($product->description)
                    $desc .= $product->description . ',';
                else
                    $desc .= '-,';
                $price_original += $product->price_original * $counts[$index];
                $tPrice += $product->price * $counts[$index];
                $tOff += $product->price * $product->off / 100 * $counts[$index];
                $tFinal += ($product->price - ($product->price * $product->off / 100)) * $counts[$index];
            }

            if ($tFinal >= 30000) $send_price = 0;

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

            $type = "";
            if ($order->pay_method == 'online') $type = "آنلاین";
            else if ($order->pay_method == 'place') $type = "حضوری";

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

            if ($order->user_phone != '09123456789' && $order->user_phone != '09182180519' && $order->user_phone != '09182180520')
                SendSMS::dispatch([
                    "msg" => ["سفارش ( " . $type . " ) جدید ثبت شد"],
                    "phone" => ["09188167800"]
                ])
                    ->onQueue('sms');

            return true;
        } else {
            return false;
        }
    }

    public function getFactor($code)
    {
        $file = public_path() . '/ftp/factors/' . $code . '.pdf';
        $headers = array(
            'Content-Type: application/pdf',
        );
        return response()->download($file, $code . '.pdf', $headers);
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

    private function getOrderHour()
    {
        $date = new DateTime();
        $date->setTimeZone(new DateTimeZone("Asia/Tehran"));
        $hour = $date->format('H');
        $minute = $date->format('i');
        $send_time = 9;

        if ($hour >= 9 && $hour < 10) $send_time = 11;
        if ($hour >= 10 && $hour < 11)
            if ($minute <= 40)
                $send_time = 11;
            else
                $send_time = 16;

        if ($hour >= 11 && $hour < 15) $send_time = 16;
        if ($hour >= 15 && $hour < 16)
            if ($minute <= 40)
                $send_time = 16;
            else
                $send_time = 18;

        if ($hour >= 16 && $hour < 17) $send_time = 18;
        if ($hour >= 17 && $hour < 18)
            if ($minute <= 40)
                $send_time = 18;
            else
                $send_time = 19;

        if ($hour >= 18 && $hour < 19)
            if ($minute <= 50)
                $send_time = 19;
            else
                $send_time = 9;

        if ($hour >= 19 && $hour <= 23) $send_time = 9;
        if ($hour >= 0 && $hour < 8) $send_time = 9;
        if ($hour >= 8 && $hour < 9)
            if ($minute <= 40)
                $send_time = 9;
            else
                $send_time = 11;

        return $send_time;
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