<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Services\v1;


use App\Author;
use App\Comment;
use App\Common\Utility;
use App\Product;
use App\Seller;
use Illuminate\Support\Facades\Log;

class SellerService
{
    protected $supportedIncludes = [
        'author' => 'author'
    ];

    protected $clauseProperties = [
        'unique_id',
        'type'
    ];

    /**
     * @param $parameters
     * @return array
     */
    public function getSellers($parameters)
    {
        if (empty($parameters)) return $this->filterSellers(Seller::all());

        $withKeys = $this->getWithKeys($parameters);
        $whereClauses = $this->getWhereClauses($parameters);

        $sellers = Seller::with($withKeys)->where($whereClauses)->get();

        return $this->filterSellers($sellers, $withKeys);
    }

    public function getSeller($parameters)
    {
        $id = $parameters['unique_id'];
        $seller = Seller::where("unique_id", $id)->firstOrFail();
        $final_seller = [
            'unique_id' => $seller->unique_id,
            'name' => $seller->name,
            'type' => $seller->type,
            'description' => $seller->description,
            'image' => $seller->image,
            'address' => $seller->address,
            'open_hour' => $seller->open_hour,
            'close_hour' => $seller->close_hour,
            'min_price' => $seller->min_price,
            'send_price' => $seller->send_price,
            'location_x' => $seller->location_x,
            'location_y' => $seller->location_y
        ];
        return $final_seller;
    }

    public function getSellerComments($parameters)
    {
        $id = $parameters['unique_id'];
        $comment = Comment::where([
            'target_id' => $id,
            'target_type' => 0
        ])->get();
        return $comment;
    }

    public function getSellerProducts($parameters)
    {
        $id = $parameters['unique_id'];
        $product = Product::where("seller_id", $id)->get();
        return $product;
    }

    /**
     * @param $request
     * @return boolean
     */
    public function createSeller($request)
    {
        Utility::stripXSS();
        $seller = new Seller();

        $seller->unique_id = uniqid('', false);
        $seller->author_id = $request->input('author_id');
        $seller->name = $request->input('name');
        $seller->address = $request->input('address');
        $seller->open_hour = $request->input('open_hour');
        $seller->close_hour = $request->input('close_hour');
        $seller->type = $request->input('type');
        $seller->phone = $request->input('phone');
        $seller->state = $request->input('state');
        $seller->city = $request->input('city');
        if (app('request')->exists('description')) $seller->description = $request->input('description');
        $seller->send_price = $request->input('send_price');
        $seller->min_price = $request->input('min_price');
        if (app('request')->exists('location_x')) $seller->location_x = $request->input('location_x');
        if (app('request')->exists('location_y')) $seller->location_y = $request->input('location_y');

        $seller->save();

        return true;
    }

    /**
     * @param $request
     * @param $id
     * @return bool
     */
    public function updateSeller($request, $id)
    {
        $seller = Seller::where('unique_id', $id)->firstOrFail();

        if (app('request')->exists('address')) $seller->address = $request->input('address');

        if (app('request')->exists('open_hour')) $seller->open_hour = $request->input('open_hour');

        if (app('request')->exists('close_hour')) $seller->close_hour = $request->input('close_hour');

        if (app('request')->exists('phone')) $seller->phone = $request->input('phone');

        if (app('request')->exists('description')) $seller->description = $request->input('description');

        if (app('request')->exists('send_price')) $seller->send_price = $request->input('send_price');

        if (app('request')->exists('min_price')) $seller->min_price = $request->input('min_price');

        if (app('request')->exists('location_x')) $seller->location_x = $request->input('location_x');

        if (app('request')->exists('location_y')) $seller->location_y = $request->input('location_y');

        if (app('request')->exists('point')) $seller->point = $request->input('point');

        if (app('request')->exists('point_count')) $seller->point_count = $request->input('point_count');

        if (app('request')->exists('off')) $seller->off = $request->input('off');

        if (app('request')->exists('closed')) $seller->closed = $request->input('closed');

        if (app('request')->exists('video')) $seller->video = $request->input('video');

        $seller->save();

        return true;
    }

    /**
     * @param $id
     */
    public function deleteSeller($id)
    {
        $seller = Seller::where('unique_id', $id)->firstOrFail();
        $seller->delete();
    }

    /**
     * @param $sellers
     * @param array $keys
     * @return array
     */
    protected function filterSellers($sellers, $keys = [])
    {
        $data = [];

        foreach ($sellers as $seller) {
            $entry = [
                'unique_id' => $seller->unique_id,
                'author_id' => $seller->author_id,
                'name' => $seller->name,
                'image' => $seller->image,
                'point' => $seller->point,
                'point_count' => $seller->point_count,
                'address' => $seller->address,
                'open_hour' => $seller->open_hour,
                'close_hour' => $seller->close_hour,
                'off' => $seller->off,
                'type' => $seller->type,
                'closed' => $seller->closed,
                'confirmed' => $seller->confirmed,
                'phone' => $seller->phone,
                'country' => $seller->country,
                'state' => $seller->state,
                'city' => $seller->city,
                'video' => $seller->video,
                'description' => $seller->description,
                'send_price' => $seller->send_price,
                'min_price' => $seller->min_price,
                'location_x' => $seller->location_x,
                'location_y' => $seller->location_y,
                'created_at' => $seller->create_date
            ];

            if (in_array('author', $keys))
                $entry['author'] = [
                    'name' => Author::where('unique_id', $seller->author_id)->get()[0]->name
                ];

            $data[] = $entry;
        }
        return $data;
    }

    protected function filterComments($comments)
    {
        $data = [];

        foreach ($comments as $comment) {
            if ($comment->confirmed) {
                $entry = [
                    'body' => $comment->body,
                    'answer' => $comment->answer,
                    'sender_name' => $comment->sender_name,
                    'create_date' => $comment->created_at,
                ];

                $data[] = $entry;
            }
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
            $includeParams = explode(',', $parameters['include']);
            $includes = array_intersect($this->supportedIncludes, $includeParams);
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