<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Services\v1;

use App\Category1;
use App\Category2;
use App\Category3;
use App\Product;
use Illuminate\Support\Facades\Log;

class CategoryService
{
    public function getGroupCategories($request)
    {
        $index = $request['index'];
        $level = $request['level'];
        $parent = $request['parent'];

        $data = [];
        $categories = [];

        if ($level == 1) {
            $categories = Category1::orderBy('name', 'asc')->skip(($index - 1) * 10)->take(10)->get();
        } else if ($level == 2) {
            if ($parent != 'n')
                $categories = Category2::where("parent_id", $parent)->orderBy('name', 'asc')->skip(($index - 1) * 10)->take(10)->get();
            else
                $categories = Category2::orderBy('name', 'asc')->skip(($index - 1) * 10)->take(10)->get();
        } else if ($level == 3) {
            if ($parent != 'n')
                $categories = Category3::where("parent_id", $parent)->orderBy('name', 'asc')->skip(($index - 1) * 10)->take(10)->get();
            else
                $categories = Category3::orderBy('name', 'asc')->skip(($index - 1) * 10)->take(10)->get();
        }

        foreach ($categories as $category) {
            $entry = [
                'unique_id' => $category->unique_id,
                'name' => $category->name,
                'image' => $category->image,
                'point' => $category->point,
                'point_count' => $category->point_count,
                'off' => $category->off,
                'level' => $level
            ];

            $data[] = $entry;
        }

        return $data;
    }

    public function getProducts($request)
    {
        $level = $request['level'];
        $id = $request['id'];

        $data = [];

        if ($level == 3) {
            $products = Product::where("category_id", $id)
                ->where("confirmed", 1)
                ->orderBy("created_at", "desc")
                ->get();

            foreach ($products as $product) {
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
                    'price' => $product->price
                ];

                $data[] = $entry;
            }
        } else if ($level == 2) {
            $categories = Category3::where("parent_id", $id)->get();
            foreach ($categories as $category) {
                $products = Product::where("category_id", $category->unique_id)
                    ->where("confirmed", 1)
                    ->orderBy("created_at", "desc")
                    ->get();

                foreach ($products as $product) {
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
                        'price' => $product->price
                    ];

                    $data[] = $entry;
                }
            }
        } else if ($level == 1) {
            $temp = [];
            $cat2 = Category2::where("parent_id", $id)->get();
            foreach ($cat2 as $c2) {
                $cat3 = Category3::where("parent_id", $c2->unique_id)->get();
                foreach ($cat3 as $c3) {
                    $temp[] = $c3->unique_id;
                }
            }


            foreach ($temp as $cat) {
                $products = Product::where("category_id", $cat)
                    ->where("confirmed", 1)
                    ->orderBy("created_at", "desc")
                    ->get();

                foreach ($products as $product) {
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
                        'price' => $product->price
                    ];

                    $data[] = $entry;
                }
            }
        }
        return $data;
    }
}