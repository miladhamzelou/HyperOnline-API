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
}
