<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Order;
use App\Pay;
use App\Services\v1\OrderService;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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
                'amount' => $order->price * 10,
                'redirect' => "http://hyper-online.ir/api/callback",
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
}
