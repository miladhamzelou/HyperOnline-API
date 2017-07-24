<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Services\v1\SellerService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SellerController extends Controller
{
    protected $Sellers;

    protected $rules = array(
        'author_id' => 'required|sellerAuthor',
        'name' => 'required',
        'address' => 'required',
        'open_hour' => 'required|integer|between:1,24',
        'close_hour' => 'required|integer|between:1,24',
        'type' => 'required|integer|sellerType',
        'phone' => 'required|numeric|sellerPhone',
        'state' => 'required',
        'city' => 'required',
        'send_price' => 'required|numeric',
        'min_price' => 'required|numeric'
    );

    protected $messages = array(
        'required' => 'The :this field is require',
        'sellerAuthor' => 'The :author id is invalid',
        'sellerType' => 'The :type is invalid',
        'sellerPhone' => 'The :phone number is invalid'
    );

    /**
     * SellerController constructor.
     * @param SellerService $service
     */
    public function __construct(SellerService $service)
    {
        $this->Sellers = $service;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $parameters = request()->input();
        if ($data = $this->Sellers->getSellers($parameters))
            return response()->json([
                'error' => false,
                'seller' => $data
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
                'message' => $validator->messages(),
                'rules' => $failedRules
            ], 500);
        } else {
            try {
                $this->Sellers->createSeller($request);
                return response()->json([
                    'tag' => $request->input('tag'),
                    'error' => false
                ], 201);
            } catch (Exception $e) {
                return response()->json([
                    'tag' => $request->input('tag'),
                    'error' => true,
                    'message' => $e->getMessage()
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

        $seller = $this->Sellers->getSeller($parameters);
        $comment = $this->Sellers->getSellerComments($parameters);
        $product = $this->Sellers->getSellerProducts($parameters);

        return response()->json([
            'error' => False,
            'seller' => $seller,
            'comment' => $comment,
            'product' => $product
        ]);
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
                'message' => $validator->messages(),
                'rules' => $failedRules
            ], 500);
        } else {
            try {
                $this->Sellers->updateSeller($request, $id);
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
                    'message' => $e->getMessage()
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
            $this->Sellers->deleteSeller($id);
            return response()->make('', 204);
        } catch (ModelNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}