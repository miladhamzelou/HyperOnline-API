<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Services\v1;

use App\Common\Utility;
use App\Order;
use App\Product;
use App\Seller;

class ProductService
{
    protected $supportedIncludes = [
        'seller' => 'seller'
    ];

    protected $clauseProperties = [
        'unique_id'
    ];

    /**
     * @param $parameters
     * @return array
     */
    public function getProducts($parameters)
    {
        if (empty($parameters)) return $this->filterProducts(Product::orderBy("created_at", "desc")->get());

        $withKeys = $this->getWithKeys($parameters);
        $whereClauses = $this->getWhereClauses($parameters);

        $products = Product::with($withKeys)->where($whereClauses)->orderBy("created_at", "desc")->get();

        return $this->filterProducts($products, $withKeys);
    }

    public function getGroupProducts($parameters)
    {
        $index = $parameters['index'];
        $category_id = $parameters['cat'];
        if (strcmp($category_id, "n") == 0)
            $products = Product::where("confirmed", 1)
                ->where("type", 0)
                ->orderBy('created_at', 'desc')
                ->skip(($index - 1) * 10)
                ->take(10)
                ->get();
        else
            $products = Product::where("confirmed", 1)
                ->where("category_id", $category_id)
                ->where("type", 0)
                ->orderBy('created_at', 'desc')
                ->skip(($index - 1) * 10)
                ->take(10)
                ->get();

        $data = [];
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

        return $products;
    }

    /**
     * @param $request
     * @return bool
     */
    public function createProduct($request)
    {
        Utility::stripXSS();
        $product = new Product();

        $product->unique_id = uniqid('', false);
        $product->seller_id = $request->input['seller_id'];
        $product->name = $request->input['name'];
        if (app('request')->exists('description')) $product->description = $request->input['description'];
        $product->price = $request->input['price'];
        $product->count = $request->input['count'];
        $product->type = $request->input['type'];

        $product->save();

        return true;
    }

    /**
     * @param $request
     * @param $id
     * @return bool
     */
    public function updateProduct($request, $id)
    {
        $product = Product::where('unique_id', $id)->firstOrFail();

        if (app('request')->exists('name')) $product->name = $request->input['name'];

        if (app('request')->exists('description')) $product->description = $request->input['description'];

        if (app('request')->exists('price')) $product->price = $request->input['price'];

        if (app('request')->exists('count')) $product->count = $request->input['count'];

        if (app('request')->exists('type')) $product->type = $request->input['type'];

        if (app('request')->exists('off')) $product->off = $request->input['off'];

        if (app('request')->exists('web3d')) $product->web3d = $request->input['web3d'];

        if (app('request')->exists('point')) $product->point = $request->input['point'];

        if (app('request')->exists('point_count')) $product->point_count = $request->input['point_count'];

        if (app('request')->exists('image')) $product->image = $request->input['image'];

        $product->save();

        return true;
    }

    /**
     * @param $id
     */
    public function deleteProduct($id)
    {
        $product = Product::where('unique_id', $id)->firstOrFail();
        $product->delete();
    }

    /**
     * @param $products
     * @param array $keys
     * @return array
     */
    protected function filterProducts($products, $keys = [])
    {
        $data = [];
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
                'confirmed' => $product->confirmed,
                'price' => $product->price,
                'created_at' => $product->create_date
            ];

            if (in_array('seller', $keys))
                $entry['seller'] = [
                    'name' => Seller::where('unique_id', $product->seller_id)->get()[0]->name
                ];

            $data[] = $entry;
        }
        return $data;
    }

    public function getProductsWithDetail($request)
    {
        $type=$request->get('type');
        $index=$request->get('index');
        if ($type == 1) {
            $products = Product::where("type", 1)
                ->orderBy("created_at", "desc")
                ->skip(($index - 1) * 20)
                ->take(20)
                ->get();
        } else if ($type == 2) {
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
            for ($i = 0; $i < 50; $i++)
                $final[] = $keys[$i];

            $products = [];

            foreach ($final as $id) {
                $data = Product::where("confirmed", 1)
                    ->where("unique_id", $id)
                    ->get();

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

                    $products[] = $entry;
                }
            }

            return $products;
        } else if ($type == 3) {
            $products = Product::where("confirmed", 1)
                ->orderBy("created_at", "desc")
                ->skip(($index - 1) * 20)
                ->take(20)
                ->get();
        } else if ($type == 4) {
            $products = Product::where("confirmed", 1)
                ->orderBy("point", "desc")
                ->skip(($index - 1) * 20)
                ->take(20)
                ->get();
        } else if ($type == 5) {
            $products = Product::where("confirmed", 1)
                ->where("off", ">", 1)
                ->orderBy("created_at", "desc")
                ->skip(($index - 1) * 20)
                ->take(20)
                ->get();
        } else if ($type == 6) {
            $products = Product::where("type", 2)
                ->orderBy("created_at", "desc")
                ->skip(($index - 1) * 20)
                ->take(20)
                ->get();
        }
        return $this->filterProducts($products);
    }

    /**
     * @param $parameters
     * @return array
     */
    protected function getWithKeys($parameters)
    {
        $withKeys = [];
        if (isset($parameters['include'])) {
            $includeParms = explode(',', $parameters['include']);
            $includes = array_intersect($this->supportedIncludes, $includeParms);
            $withKeys = array_keys($includes);
        }
        return $withKeys;
    }

    /**
     * @param $parameters
     * @return array
     */
    protected function getWhereClauses($parameters)
    {
        $clause = [];

        foreach ($this->clauseProperties as $prop)
            if (in_array($prop, array_keys($parameters)))
                $clause[$prop] = $parameters[$prop];

        return $clause;
    }
}