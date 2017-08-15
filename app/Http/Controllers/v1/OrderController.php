<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Pay;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function callback(Request $request)
    {
        $pay = new Pay();
        $pay->status = $request->input('status');
        $pay->transId = $request->input('transId');
        $pay->factorNumber = $request->input('factorNumber');
        $pay->cardNumber = $request->input('cardNumber');
        $pay->message = $request->input('message');
        $pay->save();
    }
}
