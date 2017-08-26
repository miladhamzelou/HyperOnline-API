<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Pay;
use App\Services\v1\OrderService;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $Orders;

    /**
     * ProductController constructor.
     * @param OrderService $service
     */
    public function __construct(OrderService $service)
    {
        require(app_path() . '/Common/jdf.php');
        require(app_path() . '/Common/MYPDF.php');
        $this->Orders = $service;
    }

    public function callback(Request $request)
    {
        $pay = new Pay();
        if (app('request')->exists('status'))
            $pay->status = $request->input('status');
        if (app('request')->exists('transId'))
            $pay->transId = $request->input('transId');
        if (app('request')->exists('factorNumber'))
            $pay->factorNumber = $request->input('factorNumber');
        if (app('request')->exists('cardNumber'))
            $pay->cardNumber = $request->input('cardNumber');
        if (app('request')->exists('message'))
            $pay->message = $request->input('message');
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
}
