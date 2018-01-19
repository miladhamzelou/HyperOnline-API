<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Services\v1;

use App\Banner;
use App\Category1;
use App\Option;
use App\Product;
use App\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

include(app_path() . '/Common/jdf.php');

class MainService
{
    /**
     * new products
     * @return array|string
     */
    public function getNew()
    {
        $option = Option::firstOrFail();
        if ($option->new) {
            $data = Product::where("confirmed", 1)->orderBy('created_at', 'desc')->take($option->new_count)->get();
            return $this->filterProduct($data);
        } else
            return "n";
    }

    /**
     * popular products
     * @return array|string
     */
    public function getPopular()
    {
        $option = Option::firstOrFail();
        if ($option->popular) {
            $data = Product::where("confirmed", 1)->orderBy('point', 'desc')->take($option->popular_count)->get();
            return $this->filterProduct($data);
        } else
            return "n";
    }

    /**
     * most sold products
     * @return array|string
     */
    public function getMostSell()
    {
        $option = Option::firstOrFail();

        if ($option->most_sell) {
            $most = Product::where("confirmed", 1)
                ->orderBy("sell", "desc")
                ->take($option->most_sell_count)
                ->get();

            return $this->filterProduct($most);
        } else
            return "n";
    }

    /**
     * all categories
     * @return array
     */
    public function getCategories()
    {
        $option = Option::firstOrFail();

        $categories = Category1::orderBy('created_at', 'desc')->take($option->category_count)->get();

        $data = [];
        foreach ($categories as $category) {
            $entry = [
                'unique_id' => $category->unique_id,
                'name' => $category->name,
                'image' => $category->image,
                'point' => $category->point,
                'point_count' => $category->point_count,
                'off' => $category->off,
                'level' => 1,
            ];

            $data[] = $entry;
        }

        return $data;
    }

    /**
     * application options
     * @return array
     */
    public function getOptions()
    {
        $option = Option::firstOrFail();
        $data = [
            'o' => $option->off,
            'n' => $option->new,
            'm' => $option->most_sell,
            'p' => $option->popular,
            'c' => $option->collection,
            'b' => $option->banner,
            'v' => $option->version
        ];
        return $data;
    }

    /**
     * return offline status
     * @return array
     */
    public function getOffline()
    {
        $option = Option::firstOrFail();
        return [
            'off' => $option->offline,
            'off_msg' => $option->offline_msg
        ];
    }

    /**
     * collection or event products
     * @return array|string
     */
    public function getCollections()
    {
        $option = Option::firstOrFail();
        if ($option->collection) {
            $products = Product::where("confirmed", 1)
                ->where("type", ">", 0)
                ->orderBy("created_at", "desc")
                ->take($option->collection_count)
                ->get();
            return $this->filterProduct($products);
        } else
            return "n";
    }

    /**
     * products with off
     * @return array|string
     */
    public function getOffs()
    {
        $option = Option::firstOrFail();
        if ($option->off) {
            $products = Product::where("confirmed", 1)
                ->where("off", ">", 1)
                ->orderBy("off", "desc")
                ->take($option->off_count)
                ->get();
            return $this->filterProduct($products);
        } else
            return "n";
    }

    public function Search(Request $request)
    {
        $word = $request->get('word');

        $products = Product::where(function ($query) use ($word) {
            $query->where('name', 'LIKE', '%' . $word . '%');
            $query->orWhere('description', 'LIKE', '%' . $word . '%');
        })->where("confirmed", 1)->get();

//        $products = Product::where('name', 'LIKE', '%' . $word . '%')
//            ->orWhere('description', 'LIKE', '%' . $word . '%')
//            ->where("confirmed", 1)
//            ->get();
        if (count($products) > 0)
            return $this->filterProduct($products);
        else
            return 0;
    }

    /**
     * filter products to send only needed values
     * @param $products
     * @return array
     */
    protected function filterProduct($products)
    {
        $data = [];

        foreach ($products as $product) {
            $entry = [
                'unique_id' => $product->unique_id,
                'name' => $product->name,
                'image' => $product->image,
                'point' => $product->point,
                'point_count' => $product->point_count,
                'description' => $product->description,
                'off' => $product->off,
                'count' => $product->count,
                'price' => $product->price,
            ];

            $data[] = $entry;
        }

        return $data;
    }

    public function getSendPrice()
    {
        $seller = Seller::firstOrFail();
        return $seller->send_price;
    }

    public function getBanners()
    {
        $banners = Banner::where("type", 0)->get();

        if (count($banners) > 0) {
            $data = [];

            foreach ($banners as $banner) {
                $entry = [
                    'title' => $banner->title,
                    'image' => $banner->image,
                ];

                $data[] = $entry;
            }
            Log::info($data);
            return $data;
        } else
            return 0;
    }
}