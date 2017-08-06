<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Services\v1\MainService;
use Exception;
use Illuminate\Http\Request;

class MainController extends Controller
{
    protected $Main;

    /**
     * UserController constructor.
     * @param MainService $service
     */
    public function __construct(MainService $service)
    {
        $this->Main = $service;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $new = $this->Main->getNew();
            //$popular = $this->Main->getPopular();
            $category = $this->Main->getCategories();
            //$options = $this->Main->getOptions();
            //$most = $this->Main->getMostSell();
            //if ($new && $popular && $category && $options && $most)
            if ($new && $category )
                return response()->json([
                    'error' => false,
                    'new' => $new,
                    //'popular' => $popular,
                    'category' => $category,
                    //'options' => $options,
                    //'most' => $most
                ], 201);
            else
                return response()->json([
                    'error' => true,
                    'error_msg' => "something's wrong"
                ], 201);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'error_msg' => $e->getMessage()
            ], 500);
        }
    }
}
