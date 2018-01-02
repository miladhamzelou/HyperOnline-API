<?php

namespace App\Services\v1\market;

use App\Category1;
use App\Category2;
use App\Category3;
use App\Product;
use Faker\Factory as Faker;

class MainService
{
    public function getNew()
    {
        $result = Product::where("confirmed", 1)
            ->orderBy("created_at", "desc")
            ->take(8)
            ->get();
        return $this->filterProduct($result);
    }

    public function getCategories()
    {
        $array = array();

        $cat1 = $this->filterCategory(Category1::get()->toArray(), 1);
        foreach ($cat1 as $category1) {
            array_push($array, $category1);
            $cat2 = $this->filterCategory(Category2::where("parent_id", $category1['unique_id'])->get()->toArray(), 2);
            foreach ($cat2 as $category2) {
                array_push($array, $category2);
                $cat3 = $this->filterCategory(Category3::where("parent_id", $category2['unique_id'])->get()->toArray(), 3);
                foreach ($cat3 as $category3)
                    array_push($array, $category3);
            }
        }

        return $array;
    }

    public function getProducts($level, $cat_id)
    {
        $data = [];

        if ($level == 1) {
            $temp = [];
            $cat2 = Category2::where("parent_id", $cat_id)->get();
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

                foreach ($products as $product)
                    $data[] = $product;
            }
            return $data;
        } else if ($level == 2) {
            $categories = Category3::where("parent_id", $cat_id)->get();
            foreach ($categories as $category) {
                $products = Product::where("category_id", $category->unique_id)
                    ->where("confirmed", 1)
                    ->orderBy("created_at", "desc")
                    ->get();
                foreach ($products as $product)
                    $data[] = $product;
            }
            return $data;
        } else if ($level == 3) {
            $products = Product::where("category_id", $cat_id)
                ->where("confirmed", 1)
                ->orderBy("created_at", "desc")
                ->get();

            return $this->filterProduct($products);
        }
    }

    public function getSubCategories($level, $id)
    {
        if ($level == 2)
            $data = $this->filterCategory(Category3::where("parent_id", $id)->get(), 3);
        else if ($level == 1)
            $data = $this->filterCategory(Category2::where("parent_id", $id)->get(), 2);

        return $data;
    }

    public function getCategoryName($level, $id)
    {
        if ($level == 3)
            return Category3::where("unique_id", $id)->firstOrFail()->toArray()['name'];
        else if ($level == 2)
            return Category2::where("unique_id", $id)->firstOrFail()->toArray()['name'];
        else if ($level == 1)
            return Category1::where("unique_id", $id)->firstOrFail()->toArray()['name'];
        return "";
    }

    public function getMostSell()
    {
        $most = Product::where("confirmed", 1)
            ->orderBy("sell", "desc")
            ->take(8)
            ->get();

        return $this->filterProduct($most);
    }

    public function getRandomCategory()
    {
        $faker = Faker::create();

        $categories = Category3::all()->pluck('unique_id')->toArray();
        $category = $faker->randomElement($categories);
        $products = Product::where("category_id", $category)->get();
        $cat = Category3::where("unique_id", $category)->firstOrFail();

        if (count($products)) {
            return [
                "name" => $cat->name,
                "id" => $cat->unique_id,
                "products" => $this->filterProduct($products)
            ];
        } else {
            return $this->getRandomCategory();
        }
    }

    public function getRandomCategory2()
    {
        $faker = Faker::create();
        $data = [];
        $categories = Category1::all()->pluck('unique_id')->toArray();
        $cat = $faker->randomElement($categories);
        $cat = Category2::where("parent_id", $cat)->firstOrFail();
        $categories = Category3::where("parent_id", $cat->unique_id)->get();
        if (count($categories)) {
            foreach ($categories as $category) {
                $products = Product::where("category_id", $category->unique_id)
                    ->where("confirmed", 1)
                    ->orderBy("created_at", "desc")
                    ->get();
                foreach ($products as $product)
                    $data[] = $product;
            }

            return [
                "name" => $cat->name,
                "id" => $cat->unique_id,
                "products" => $this->filterProduct($data),
                "subs" => $this->getSubCategories(2, $cat->unique_id)
            ];
        } else
            return $this->getRandomCategory2();
    }

    public function getOff()
    {
        $products = Product::where("off", '>', 0)->take(10)->get();
        return $this->filterProduct($products);
    }

    protected function filterProduct($products)
    {
        $data = [];
        foreach ($products as $product) {
            $entry = [
                'unique_id' => $product['unique_id'],
                'name' => $product['name'],
                'image' => $product['image'],
                'description' => $product['description'],
                'off' => $product['off'],
                'price' => $product['price'],
                'category_id' => $product['category_id']
            ];

            $data[] = $entry;
        }
        return $data;
    }

    protected function filterCategory($category, $level)
    {
        $data = [];
        foreach ($category as $item) {
            $entry = [
                'unique_id' => $item['unique_id'],
                'parent_id' => $item['parent_id'],
                'image'=>$item['image'],
                'name' => $item['name'],
                'level' => $level
            ];
            $data[] = $entry;
        }
        return $data;
    }
}