<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Libraries\EncryptionHelper;
use App\Services\v1\UserService;
use Exception;
use Illuminate\Http\Request;

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
        try {
            $encryption = new EncryptionHelper();
            $json = $encryption->getJSON($request->getContent());
            if ($data = $this->Users->checkUser($json))
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
                'error_msg' => 'مشکلی پیش آمده است'
            ], 201);
        }
    }
}
