<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Services\v1\UserService;
use App\Support;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
        $validator = Validator::make($request->all(), $this->rules, $this->messages);

        if (!$this->Users->checkExists($request)) {
            if ($validator->fails()) {
                $failedRules = $validator->failed();
                return response()->json([
                    'tag' => 'validation',
                    'error' => true,
                    'error_msg' => $validator->messages(),
                    'rules' => $failedRules
                ], 201);
            } else {
                try {
                    if ($this->Users->createUser($request)) {
                        return response()->json([
                            'error' => false
                        ], 201);
                    } else
                        return response()->json([
                            'error' => true,
                            'error_msg' => "Register Error"
                        ], 201);
                } catch (Exception $e) {
                    return response()->json([
                        'tag' => $request->input('tag'),
                        'error' => true,
                        'error_msg' => $e->getMessage()
                    ], 201);
                }
            }
        } else
            return response()->json([
                'error' => true,
                'error_msg' => "این شماره قبلا ثبت شده است"
            ], 201);
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
            ], 201);
        } else {
            try {
                if ($this->Users->checkUser($request))
                    return response()->json([
                        'error' => false
                    ], 201);
                else
                    return response()->json([
                        'error' => true,
                        'error_msg' => "Login Problem"
                    ], 201);
            } catch (Exception $e) {
                return response()->json([
                    'error' => true,
                    'error_msg' => $e->getMessage()
                ], 201);
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
            ], 201);
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
            ], 201);
    }

    public function checkConfirm(Request $request)
    {
        $phoneNumber = $request->get('phone');
        $user = User::where("phone", $phoneNumber)->firstOrFail();
        if ($user) {
            if ($user->confirmed_info == "1")
                return response()->json([
                    'error' => false,
                    'c' => 'OK'
                ], 201);
            else
                return response()->json([
                    'error' => false,
                    'c' => 'NOK'
                ], 201);
        } else
            return response()->json([
                'error' => true,
                'error_msg' => "این شماره ثبت نشده است"
            ], 201);
    }

    public function updateUser(Request $request)
    {
        try {
            $name = $request->get("name");
            $id = $request->get("uid");
            $address = $request->get("address");

            $user = User::where("unique_id", $id)->firstOrFail();
            $user->name = $name;
            $user->address = $address;
            $user->confirmed_info = 0;
            $user->save();

            $support = new Support();
            $support->unique_id = uniqid('', false);
            $support->section = "اطلاعات کاربر";
            $support->body = "کاربر " . $user->name . " اطلاعات خود را تغییر داد. حساب کاربری نیاز به تایید دارد";
            $support->log = 0;

            Mail::to("hatamiarash7@gmail.com")
                ->send(new \App\Mail\Support($support));

            return response()->json([
                'error' => false,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'error_msg' => $e->getMessage()
            ], 201);
        }
    }
}