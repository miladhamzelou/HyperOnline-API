<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Services\v1\MainService;
use Exception;
use Illuminate\Http\Request;

class MainController extends Controller
{
    protected $Data;

    protected $rules = array(
        'phone' => 'required|numeric|userPhone'
    );

    protected $messages = array(
        'userPhone' => 'The :phone number is invalid'
    );

    /**
     * UserController constructor.
     * @param MainService $service
     */
    public function __construct(MainService $service)
    {
        $this->Data = $service;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            if ($data = $this->Data->getData())
                return response()->json([
                    'error' => false,
                    'user' => $data
                ], 201);
            else
                return response()->json([
                    'error' => true,
                    'error_msg' => 'اطلاعات وارد شده صحیح نمی باشد'
                ], 201);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'error_msg' => $e->getMessage()
            ], 500);
        }
    }
}
