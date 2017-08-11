<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Services\v1;

use App\Category1;
use App\Option;
use App\Order;
use App\Product;

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
            $orders = Order::get();
            $all_stuffs = array();
            foreach ($orders as $order) {
                $stuffs = explode('-', $order->stuffs_id);
                for ($i = 0; $i < sizeof($stuffs); $i++)
                    array_push($all_stuffs, $stuffs[$i]);
            }

            $count = array_count_values($all_stuffs);
            arsort($count);
            $keys = array_keys($count);

            $final = [];
            for ($i = 0; $i < $option->most_sell_count; $i++)
                $final[] = $keys[$i];

            $most = [];

            foreach ($final as $id) {
                $data = Product::where("confirmed", 1)->where("unique_id", $id)->get();

                foreach ($data as $product) {
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

                    $most[] = $entry;
                }
            }

            return $most;
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

        $categories = Category1::orderBy('point', 'desc')->take($option->category_count)->get();

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
            'm' => $option->most,
            'p' => $option->popular,
            'c' => $option->collection
        ];
        return $data;
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
                ->orderBy("updated_at", "desc")
                ->take($option->off_count)
                ->get();
            return $this->filterProduct($products);
        } else
            return "n";
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
}