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
    public function getNew()
    {
        $option = Option::firstOrFail();

        $data = Product::where("confirmed", 1)->orderBy('created_at', 'desc')->take($option->new_count)->get();

        $new = [];
        foreach ($data as $product) {
            $entry = [
                'unique_id' => $product->unique_id,
                'seller_id' => $product->seller_id,
                'category_id' => $product->category_id,
                'name' => $product->name,
                'image' => $product->image,
                'point' => $product->point,
                'point_count' => $product->point_count,
                'description' => $product->description,
                'off' => $product->off,
                'count' => $product->count,
                'price' => $product->price,
                'created_at' => $product->create_date
            ];

            $new[] = $entry;
        }

        return $new;
    }

    public function getPopular()
    {
        $option = Option::firstOrFail();

        $data = Product::where("confirmed", 1)->orderBy('point', 'desc')->take($option->popular_count)->get();

        $popular = [];
        foreach ($data as $product) {
            $entry = [
                'unique_id' => $product->unique_id,
                'seller_id' => $product->seller_id,
                'category_id' => $product->category_id,
                'name' => $product->name,
                'image' => $product->image,
                'point' => $product->point,
                'point_count' => $product->point_count,
                'description' => $product->description,
                'off' => $product->off,
                'count' => $product->count,
                'price' => $product->price,
                'created_at' => $product->create_date
            ];

            $popular[] = $entry;
        }

        return $popular;
    }

    public function getCategories()
    {
        $option = Option::firstOrFail();

        $data = Category1::orderBy('point', 'desc')->take($option->category_count)->get();

        $category = [];
        foreach ($data as $product) {
            $entry = [
                'unique_id' => $product->unique_id,
                'seller_id' => $product->seller_id,
                'name' => $product->name,
                'image' => $product->image,
                'point' => $product->point,
                'point_count' => $product->point_count,
                'description' => $product->description,
                'off' => $product->off,
                'count' => $product->count,
                'price' => $product->price,
                'created_at' => $product->create_date
            ];

            $category[] = $entry;
        }

        return $category;
    }

    public function getMostSell()
    {
        $option = Option::firstOrFail();

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
                    'seller_id' => $product->seller_id,
                    'category_id' => $product->category_id,
                    'name' => $product->name,
                    'image' => $product->image,
                    'point' => $product->point,
                    'point_count' => $product->point_count,
                    'description' => $product->description,
                    'off' => $product->off,
                    'count' => $product->count,
                    'price' => $product->price,
                    'created_at' => $product->create_date
                ];

                $most[] = $entry;
            }
        }

        return $most;
    }

    public function getOptions()
    {
        $has_event = 0;
        $has_collection = 0;
        $data = Category1::get();

        foreach ($data as $product) {
            if ($product->type == 2) $has_event = 1;
            if ($product->type == 1) $has_collection = 1;
        }

        return [
            'event' => $has_event,
            'collection' => $has_collection
        ];
    }

}