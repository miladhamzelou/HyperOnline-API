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
use Illuminate\Support\Facades\View;

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
            return view('home');
    }

    public function profile()
    {

    }

    public function admin()
    {
        if (Auth::user()->Role() != "admin")
            return redirect()->route('profile');
        $title = "صفحه اصلی";
        $description = "خلاصه آمار";
        $category_count = count(Category3::get());
        $product_count = count(Product::get());
        $order_count = count(Order::get());
        $user_count = count(User::get());
        $data = array('title' => $title,
            'description' => $description,
            'category_count' => $category_count,
            'product_count' => $product_count,
            'order_count' => $order_count,
            'user_count' => $user_count);
        $weeks = ['a', 'b', 'c', 'd', 'e', 'f', 'g'];
        $orders = ['12', '25', '14', '21', '5', '16', '14'];
        return View::make('admin.dashboard')
            ->with($data)
            ->with($weeks)
            ->with($orders);
    }
}