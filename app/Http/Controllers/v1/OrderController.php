<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use App\Jobs\SendSMS;
use App\Order;
use App\Pay;
use App\Product;
use App\Seller;
use App\Services\v1\OrderService;
use App\User;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
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
        require(app_path() . '/Common/jdf.php');
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
                    'orders' => $result,
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
//                'amount' => $order->price * 10,
                'amount' => 1000,
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
//            $this->completeOrder($pay->factorNumber);
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

        SendSMS::dispatch([
            "msg" => ["سفارش ( " . $type . " ) جدید ثبت شد"],
            "phone" => ["09188167800"]
        ])
            ->onQueue('sms');

        return response()->json([
            'error' => false
        ], 201);
    }
}