<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Services\v1\UserService;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use phplusir\smsir\Smsir;

class UserController extends Controller
{
    protected $Users;

    protected $rules = array(
        'name' => 'required',
        'address' => 'required',
        'phone' => 'required|numeric|userPhone',
        'state' => 'required',
        'city' => 'required',
        'email' => 'email'
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $parameters = request()->input();
        $data = $this->Users->getUsers($parameters);
        return response()->json($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        Log::info("request:\n" . $request);
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
                $this->Users->createUser($request);
                return response()->json([
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
        $data = $this->Users->getUser($id);
        return response()->json([
            'error' => false,
            'user' => $data
        ], 201);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), array(
            'unique_id' => 'required',
            'phone' => 'numeric|userPhone',
            'email' => 'email'
        ));

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
                $this->Users->updateUser($request, $id);
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
            $this->Users->deleteUser($id);
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

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), array(
            'phone' => 'numeric|userPhone'
        ));

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
                if ($this->Users->checkUser($request))
                    return response()->json([
                        'error' => false
                    ], 201);
                else
                    return response()->json([
                        'error' => true
                    ], 409);
            } catch (Exception $e) {
                return response()->json([
                    'error' => true,
                    'error_msg' => $e->getMessage()
                ], 500);
            }
        }
    }

    public function phoneVerification(Request $request)
    {
        $phoneNumber = $request->get('phone');
        $user = User::where("phone", $phoneNumber)->firstOrFail();
        if ($user) {
            $code = mt_rand(1527, 5388);
            $message = "هایپرآنلاین - کد فعال سازی شما :‌ " . $code;
            Smsir::send([$message], [$phoneNumber]);
            return response()->json([
                'error' => false,
                'code' => $code + 4611
            ], 201);
        } else
            return response()->json([
                'error' => true,
                'error_msg' => "این شماره ثبت نشده است"
            ], 500);
    }

    public function phoneVerificationOK(Request $request)
    {
        $phoneNumber = $request->get('phone');
        $user = User::where("phone", $phoneNumber)->firstOrFail();
        if ($user) {
            $user->confirmed_phone = 1;
            $user->save();
            return response()->json([
                'error' => false
            ], 201);
        } else
            return response()->json([
                'error' => true,
                'error_msg' => "این شماره ثبت نشده است"
            ], 500);
    }
}