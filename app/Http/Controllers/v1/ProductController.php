<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Services\v1\ProductService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    protected $Products;

    protected $rules = array(
        'seller_id' => 'required|productSeller',
        'name' => 'required',
        'price' => 'required'
    );

    protected $messages = array(
        'required' => 'The :this field is require',
        'productSeller' => 'The :seller id is invalid'
    );

    /**
     * ProductController constructor.
     * @param ProductService $service
     */
    public function __construct(ProductService $service)
    {
        $this->Products = $service;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        /*$parameters = request()->input();
        //Log::info('parameters' . implode("|",$parameters));
        Log::info('parameters' . $parameters);
        $seller = Seller::where("unique_id", $parameters['unique_id'])->firstOrFail();
        $final_seller = [
            'unique_id' => $seller->unique_id,
            'name' => $seller->name,
            'type' => $seller->type,
            'description' => $seller->description,
            'address' => $seller->address,
            'open_hour' => $seller->open_hour,
            'close_hour' => $seller->close_hour,
            'min_price' => $seller->min_price,
            'send_price' => $seller->send_price
        ];
        Log::info("seller's detail\n" . $final_seller);
        $comment = Comment::where([
            'target_id' => $parameters['unique_id'],
            'target_type' => 0
        ])->get();
        Log::info("\ncomments" . $comment);
        if ($product = $this->Products->getProducts($parameters))
            return response()->json([
                'error' => false,
                'seller' => $final_seller,
                'comment' => $this->filterComments($comment),
                'product' => $product
            ], 201);
        else
            return response()->json([
                'error' => true
            ], 201);*/

        $parameters = request()->input();
        if ($data = $this->Products->getProducts($parameters))
            return response()->json([
                'error' => false,
                'product' => $data
            ], 201);
        else
            return response()->json([
                'error' => true
            ], 201);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            $failedRules = $validator->failed();
            return response()->json([
                'tag' => 'validation',
                'error' => true,
                'error_msg' => $validator->messages(),
                'rules' => $failedRules
            ], 500);
        } else {
            try {
                $this->Products->createProduct($request);
                return response()->json([
                    'tag' => $request->input('tag'),
                    'error' => false
                ], 201);
            } catch (Exception $e) {
                return response()->json([
                    'tag' => $request->input('tag'),
                    'error' => true,
                    'error_msg' => $e->getMessage()
                ], 500);
            }
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $parameters = request()->input();
        $parameters['unique_id'] = $id;
        $data = $this->Products->getProducts($parameters);
        return response()->json($data);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), array('unique_id' => 'required'));

        if ($validator->fails()) {
            $failedRules = $validator->failed();
            return response()->json([
                'tag' => 'validation',
                'error' => true,
                'error_msg' => $validator->messages(),
                'rules' => $failedRules
            ], 500);
        } else {
            try {
                $this->Products->updateProduct($request, $id);
                return response()->json([
                    'tag' => $request->input('tag'),
                    'error' => false
                ], 201);
            } catch (ModelNotFoundException $e) {
                throw $e;
            } catch (Exception $e) {
                return response()->json([
                    'tag' => $request->input('tag'),
                    'error' => true,
                    'error_msg' => $e->getMessage()
                ], 500);
            }
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->Products->deleteProduct($id);
            return response()->make('', 204);
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'error_msg' => $e->getMessage()
            ], 500);
        }
    }

    public function sectionLoad(Request $request)
    {
        $parameters = request()->input();

        try {
            if ($data = $this->Products->getGroupProducts($parameters))
                return response()->json([
                    'error' => false,
                    'product' => $data
                ], 201);
            else
                return response()->json([
                    'error' => true
                ], 201);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'error_msg' => $e->getMessage()
            ], 500);
        }
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
                    'created_at' => $comment->created_at,
                ];

                $data[] = $entry;
            }
        }
        return $data;
    }
}