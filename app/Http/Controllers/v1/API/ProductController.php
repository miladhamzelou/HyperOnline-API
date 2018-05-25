<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Http\Controllers\v1\API;

use App\Http\Controllers\Controller;
use App\Product;
use App\Services\v1\ProductService;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
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

    public function getDetails(Request $request)
    {
        try {
            if ($data = $this->Products->getProductsWithDetail($request))
                return response()->json([
                    'error' => false,
                    'products' => $data
                ], 201);
            else
                return response()->json([
                    'error' => true,
                    'error_msg' => "محصولی ثبت نشده است"
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

    public function getProduct($id)
    {
        $data = Product::where("unique_id", $id)->firstOrFail();
        return response()->json($data);
    }

    public function addToCart(Request $request)
    {
        $id = $request->get('id');
        $count = $request->get('count');

        $product = Product::where("unique_id", $id)->firstOrFail();

        Cart::add(
            $product->unique_id,
            $product->name,
            $count,
            $product->price - ($product->price * $product->off / 100),
            [
                'image' => $product->image
            ]
        );

        return $product;
    }

    public function removeFromCart(Request $request)
    {
        $id = $request->get('id');
        Cart::remove($id);
        return ['o' => 'k'];
    }
}