<?php

namespace App\Http\Controllers\v1\API;

use App\Http\Controllers\Controller;
use App\Services\v1\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    protected $Users;

    protected $rules = array(
        'phone' => 'required|numeric|userPhone'
    );

    protected $messages = array(
        'userPhone' => 'The :phone number is invalid'
    );

    /**
     * UserController constructor.
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        $this->Users = $service;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'error_msg' => $validator->messages()
            ], 201);
        } else {
            try {
                if ($data = $this->Users->checkUser($request))
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
                    'error_msg' => 'اطلاعات وارد شده صحیح نمی باشد'
                ], 201);
            }
        }
    }
}
