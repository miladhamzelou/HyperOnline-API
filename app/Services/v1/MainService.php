<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Services\v1;

use App\Category3;
use App\Product;

include(app_path() . '/Common/jdf.php');

class MainService
{
    public function getNew()
    {
        $data = Product::where("confirmed", 1)->orderBy('created_at', 'desc')->take(12)->get();

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
        $data = Product::where("confirmed", 1)->orderBy('point', 'desc')->take(12)->get();

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
        $data = Category3::orderBy('point', 'desc')->take(12)->get();

        $category = [];
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

            $category[] = $entry;
        }

        return $category;
    }
}