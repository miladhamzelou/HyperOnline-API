<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

/**
 * Created by PhpStorm.
 * User: root
 * Date: 8/12/17
 * Time: 2:35 AM
 */

namespace app\Http\Controllers\v1_web;


use App\Http\Controllers\Controller;
use App\Product;
use App\Services\v1\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected $Products;

    /**
     * ProductController constructor.
     * @param ProductService $service
     */
    public function __construct(ProductService $service)
    {
        require(app_path() . '/Common/jdf.php');
        $this->Products = $service;
    }

    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->take(50)->get();
        $title = "Products";
        return view('admin.products')
            ->withTitle($title)
            ->withProducts($products);
    }

    public function show()
    {
        if (Auth::user()->Role() == "admin") {
            $title = "Create New Product";
            return view('admin.product_create')
                ->withTitle($title);
        } else
            return redirect('/')
                ->withErrors('Unauthorized Access');
    }

    public function store(Request $request)
    {
        $product = new Product();

        $product->unique_id = uniqid('', false);
        $product->name = $request->get('name');
        $product->seller_id = $request->get('seller_id');
        $product->category_id = $request->get('category_id');
        $product->description = $request->get('description');
        $product->count = $request->get('count');
        $product->price = $request->get('price');
        $product->type = $request->get('type');
        $product->create_date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());

        $product->save();

        $message = "product created";
        return redirect('/admin/products')->withMessage($message);
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