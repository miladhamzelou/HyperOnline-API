<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Http\Controllers\v1_web;

use App\Category3;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use App\Services\v1\UserService;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $Users;

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
    public function index()
    {
        if (Auth::guest())
            return view('welcome');
        else
            if (Auth::user()->Role() != "admin")
                return view('home');
            else
                return redirect()->route('admin');
    }

    public function profile()
    {

    }
}