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
        $data = Product::where("confirmed", 1)->orderBy('created_at', 'desc')->take(10)->get();
        $new = [];
        foreach ($data as $product) {
            $entry = [
                'name' => $product->name
            ];
            $new[] = $entry;
        }

        return $new;
    }

    public function getPopular()
    {
        $data = Product::where("confirmed", 1)->orderBy('point', 'desc')->take(10)->get();

        $popular = [];
        foreach ($data as $product) {
            $entry = [
                'name' => $product->name
            ];
            $popular[] = $entry;
        }

        return $popular;
    }

    public function getCategories(){
        $data = Category3::orderBy('point', 'desc')->take(10)->get();

        $category = [];
        foreach ($data as $product) {
            $entry = [
                'name' => $product->name
            ];
            $category[] = $entry;
        }

        return $category;
    }
}