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


use App\Category3;
use App\Http\Controllers\Controller;
use App\Product;
use App\Seller;
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

            $sellers_list = array();
            $sellers = Seller::where("confirmed", 1)->get();
            foreach ($sellers as $seller)
                array_push($sellers_list, $seller->name);

            $categories_list = array();
            $categories = Category3::get();
            foreach ($categories as $category)
                array_push($categories_list, $category->name);

            return view('admin.product_create')
                ->withTitle($title)
                ->withSellers($sellers_list)
                ->withCategories($categories_list);
        } else
            return redirect('/')
                ->withErrors('Unauthorized Access');
    }

    public function store(Request $request)
    {
        $product = new Product();
        $seller = Seller::where("name", $request->get('seller'))->firstOrFail()->unique_id;
        $category = Category3::where("name", $request->get('category'))->firstOrFail()->unique_id;

        $product->unique_id = uniqid('', false);
        $product->name = $request->get('name');
        $product->seller_id = $seller;
        $product->category_id = $category;
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