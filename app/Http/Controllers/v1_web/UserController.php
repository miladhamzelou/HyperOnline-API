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

    public function info($id)
    {
        $user = User::where("unique_id", $id)->firstOrFail();
        if ($user->role == "admin") $user->role = "مدیر";
        if ($user->role == "user") $user->role = "کاربر";
        if ($user->role == "developer") $user->role = "توسعه دهنده";
        $user->create_date = str_replace(":", " : ", $user->create_date);
        return view('admin.user_view')
            ->withTitle($user->name)
            ->withUser($user);
    }
}