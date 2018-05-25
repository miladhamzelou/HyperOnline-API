<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace app\Http\Controllers\v1_web;


use App\Category3;
use App\Http\Controllers\Controller;
use App\Product;
use App\Seller;
use App\Services\v1\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;

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
        if (Auth::check())
            if (!Auth::user()->isAdmin())
                return view('errors.404');
        $products = Product::where("confirmed", 1)->orderBy('created_at', 'desc')->get();
        $inactive = count(Product::where("confirmed", 0)->get());
        $title = "محصولات";
        return view('admin.products')
            ->withTitle($title)
            ->withInactive($inactive)
            ->withProducts($this->fixPrice($products));
    }

    public function show()
    {
        if (Auth::user()->isAdmin()) {
            $title = "اضافه کردن محصول جدید";

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
                ->withErrors('دسترسی غیرمجاز');
    }

    public function store(Request $request)
    {
        $product = new Product();
        $seller = Seller::where("name", $request->get('seller'))->firstOrFail()->unique_id;
        $category = Category3::where("name", $request->get('category'))->firstOrFail()->unique_id;

        $uid = uniqid('', false);
        $product->unique_id = $uid;
        $product->name = $request->get('name');
        $product->seller_id = $seller;
        $product->category_id = $category;
        $product->description = $request->get('description');
        $product->count = $request->get('count');
        $product->price = $request->get('price');
        $product->price_original = $request->get('price_original');
        $product->off = $request->get('off');
        $product->type = $request->get('type');
        $product->create_date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());

        if (Input::hasFile('image')) {
            $image = $request->file('image');
            $input['imagename'] = 'P.' . $uid . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images');
            $image->move($destinationPath, $input['imagename']);
            $product->image = $input['imagename'];
        }

        $product->save();

        $message = "محصول ( " . $product->name . " ) اضافه شد";
        return redirect('/admin/products_inactive')->withMessage($message);
    }

    public function edit($id)
    {
        if (Auth::user()->isAdmin()) {
            $product = Product::where("unique_id", $id)->firstOrFail();
            $seller2 = Seller::where("unique_id", $product->seller_id)->firstOrFail();
            $category2 = Category3::where("unique_id", $product->category_id)->firstOrFail();
            $sellers_list = array();
            $sellers = Seller::where("confirmed", 1)->get();
            foreach ($sellers as $seller)
                array_push($sellers_list, $seller->name);
            $categories_list = array();
            $categories = Category3::get();
            foreach ($categories as $category)
                array_push($categories_list, $category->name);

            return view('admin.product_edit')
                ->withTitle("ویرایش محصول")
                ->withProduct($product)
                ->withSellers($sellers_list)
                ->withSeller_selected($seller2->name)
                ->withCategories($categories_list)
                ->withCategory_selected($category2->name);
        } else
            return redirect('/')
                ->withErrors('دسترسی غیرمجاز');
    }

    public function update(Request $request)
    {
        $product = Product::where("unique_id", $request->get('unique_id'))->firstOrFail();
        if ($product && Auth::user()->isAdmin()) {
            $seller = Seller::where("name", $request->get('seller'))->firstOrFail()->unique_id;
            $category = Category3::where("name", $request->get('category'))->firstOrFail()->unique_id;

            $product->name = $request->get('name');
            $product->seller_id = $seller;
            $product->category_id = $category;
            $product->description = $request->get('description');
            $product->count = $request->get('count');
            $product->price = $request->get('price');
            $product->price_original = $request->get('price_original');
            $product->off = $request->get('off');
            $product->type = $request->get('type');
            $product->confirmed = 0;

            if (Input::hasFile('image')) {
                // first delete old one
                File::delete('images/' . $product->image);
                $image = $request->file('image');
                $input['imagename'] = 'P.' . $product->unique_id . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('images');
                $image->move($destinationPath, $input['imagename']);
                $product->image = $input['imagename'];
            }

            $product->save();
            $message = "محصول ( " . $product->name . " ) به روزرسانی شد";
            return redirect('/admin/products_inactive')
                ->withMessage($message);
        } else
            return redirect('/')
                ->withErrors('دسترسی غیرمجاز');
    }

    public function delete($id)
    {
        if (Auth::user()->isAdmin()) {
            $product = Product::find($id);
            if ($product->image)
                File::delete('images/' . $product->image);
            $product->delete();
            $message = "محصول ( " . $product->name . " ) حذف شد";
            return redirect('/admin/products')
                ->withMessage($message);
        } else
            return redirect('/')
                ->withErrors('دسترسی غیرمجاز');
    }

    public function delete_photo($id)
    {
        if (Auth::user()->isAdmin()) {
            $product = Product::find($id);
            if ($product->image) {
                File::delete('images/' . $product->image);
                $product->image = null;
                $product->save();
                $message = "عکس محصول ( " . $product->name . " ) حذف شد";
            } else
                $message = "برای محصول ( " . $product->name . " ) عکسی ثبت نشده است";
            return redirect('/admin/products')->withMessage($message);
        } else
            return redirect('/')
                ->withErrors('دسترسی غیرمجاز');
    }

    public function inactive()
    {
        if (!Auth::user()->isAdmin())
            return redirect()->route('profile');
        $products = Product::where("confirmed", 0)->orderBy('created_at', 'desc')->get();
        $title = "محصولات غیرفعال";
        return view('admin.products_inactive')
            ->withTitle($title)
            ->withProducts($this->fixPrice($products));
    }

    public function active()
    {
        $products = Product::where("confirmed", 0)->get();
        foreach ($products as $product) {
            $product->confirmed = 1;
            $product->save();
        }
        $message = "تمام محصولات تایید شدند";
        return redirect('/admin/products')
            ->withMessage($message);
    }

    protected function fixPrice($items)
    {
        foreach ($items as $item)
            $item->price = $this->formatMoney($item->price);
        return $items;
    }

    protected function formatMoney($number, $fractional = false)
    {
        if ($fractional)
            $number = sprintf('%.2f', $number);
        while (true) {
            $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
            if ($replaced != $number)
                $number = $replaced;
            else
                break;
        }
        return $number;
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