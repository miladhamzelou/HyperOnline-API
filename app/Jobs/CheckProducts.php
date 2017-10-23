<?php

namespace App\Jobs;

use App\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function handle()
    {
        $products = Product::get();
        $final = '';
        foreach ($products as $product) {
            if ($product->count <= 1) {
                $final .= $product->name;
                if ($product->description)
                    $final .= '(' . $product->description . ')-';
                else
                    $final .= '-';
            }
        }
        if (strlen($final) > 0) {
            SendEmail::dispatch([
                "to" => "hatamiarash7@gmail.com",
                "body" => "موجودی محصولات مورد نظر رو به اتمام است. جهت تهییه مجدد اقدام فرمایید : " . "\r\n" . $final
            ], 0);
        }
    }
}