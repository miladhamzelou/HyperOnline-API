<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Services\v1;

use App\Comment;
use App\Common\Utility;
use App\Product;
use App\Seller;
use App\User;


class CommentService
{
    protected $supportedIncludes = [
        'target' => 'target',
        'user' => 'user'
    ];

    protected $clauseProperties = [
        'unique_id'
    ];

    /**
     * @param $parameters
     * @return array
     */
    public function getComments($parameters)
    {
        if (empty($parameters)) return $this->filterComments(Comment::all());

        $withKeys = $this->getWithKeys($parameters);
        $whereClauses = $this->getWhereClauses($parameters);

        $comments = Comment::with($withKeys)->where($whereClauses)->get();

        return $this->filterComments($comments, $withKeys);
    }

    /**
     * @param $request
     * @return bool
     */
    public function createComment($request)
    {
        Utility::stripXSS();
        $comments = new Comment();

        $comments->unique_id = uniqid('', false);
        if (app('request')->exists('target_id')) {
            $comments->target_id = $request->input['target_id'];
            $comments->target_type = $this->targetTypes($comments->target_id);
        } else {
            $comments->target_id = 'NORMAL';
            $comments->target_type = 1;
        }
        $comments->user_id = $request->input['user_id'];
        $comments->sender_name = User::where('unique_id', $comments->user_id)->get()[0]->name;
        $comments->body = $request->input['body'];

        $comments->save();

        return true;
    }

    /**
     * @param $request
     * @param $id
     * @return bool
     */
    public function updateComment($request, $id)
    {
        $comment = Comment::where('unique_id', $id)->firstOrFail();

        if (app('request')->exists('answer')) $comment->stuffs = $request->input('answer');

        if (app('request')->exists('confirmed')) $comment->stuffs = $request->input('confirmed');

        $comment->save();

        return true;
    }

    /**
     * @param $id
     */
    public function deleteComment($id)
    {
        $comment = Comment::where('unique_id', $id)->firstOrFail();
        $comment->delete();
    }


    /**
     * @param $comments
     * @param array $keys
     * @return array
     */
    protected function filterComments($comments, $keys = [])
    {
        $data = [];
        foreach ($comments as $comment) {
            $entry = [
                'unique_id' => $comment->unique_id,
                'body' => $comment->body,
                'answer' => $comment->answer,
                'created_at' => $comment->create_date
            ];

            if (in_array('target', $keys))
                $entry['target'] = [
                    'target_type' => $comment->target_type,
                    'target_id' => $comment->target_id,
                ];

            if (in_array('user', $keys))
                $entry['user'] = [
                    'sender_name' => User::where('unique_id', $comment->user_id)->get()[0]->name,
                    'user_id' => $comment->user_id
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

    /**
     * get unique_id and return target type
     * seller:0 / product:2 / normal:1
     * @param $target_id
     * @return int
     */
    protected function targetTypes($target_id)
    {
        $sellers = Seller::all()->pluck('unique_id')->toArray();
        $products = Product::all()->pluck('unique_id')->toArray();
        $type = 1;

        if (in_array($sellers, $target_id)) $type = 0;
        if (in_array($products, $target_id)) $type = 2;

        return $type;
    }
}