<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Services\v1\CategoryService;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $Categories;

    /**
     * ProductController constructor.
     * @param CategoryService $service
     */
    public function __construct(CategoryService $service)
    {
        $this->Categories = $service;
    }

    public function getCategories(Request $request)
    {
        try {
            $categories = $this->Categories->getGroupCategories2($request);
            if ($categories)
                return response()->json([
                    'error' => false,
                    'cat' => $categories,
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

    public function sectionLoad(Request $request)
    {
        try {
            $categories = $this->Categories->getGroupCategories($request);
            $products = $this->Categories->getProducts($request);

            if ($categories && $products)
                return response()->json([
                    'error' => false,
                    'category' => $categories,
                    'product' => $products
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
}