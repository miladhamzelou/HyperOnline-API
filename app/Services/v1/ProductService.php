<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Services\v1;

use App\Common\Utility;
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
        if (empty($parameters)) return $this->filterProducts(Product::all());

        $withKeys = $this->getWithKeys($parameters);
        $whereClauses = $this->getWhereClauses($parameters);

        $products = Product::with($withKeys)->where($whereClauses)->get();

        return $this->filterProducts($products, $withKeys);
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
                'type' => $product->type,
                'web3d' => $product->web3d,
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