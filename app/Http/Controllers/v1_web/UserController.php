<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Http\Controllers\v1_web;

use App\Http\Controllers\Controller;
use App\Services\v1\UserService;
use App\User;

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
        $users = User::orderBy("created_at", "desc")->get();
        return view('admin.users')
            ->withTitle("Users")
            ->withUsers($users);
    }

    public function profile()
    {

    }
}