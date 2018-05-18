<?php
/**
 * Created by PhpStorm.
 * User: hatamiarash7
 * Date: 2018-05-18
 * Time: 18:01
 */

namespace App\Http\Controllers\v1\MARKET;


use App\Http\Controllers\Controller;
use App\Seller;
use App\Services\v1\market\MainService;
use App\Services\v1\UserService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
	protected $mService;
	protected $userService;

	public function __construct(MainService $service, UserService $userService)
	{
		$this->middleware('auth');
		$this->mService = $service;
		$this->userService = $userService;
	}

	public function profile()
	{
		$seller = Seller::where('unique_id', "vbkYwlL98I3F3")->firstOrFail();
		if (Cart::content()->count() > 0)
			$send_price = $seller->send_price;
		else
			$send_price = 0;

		if ((int)str_replace(',', '', Cart::subtotal()) > 30000) {
			$send_price = 0;
			$free_ship = true;
		} else
			$free_ship = false;

		$cart = [
			'items' => Cart::content(),
			'count' => Cart::content()->count(),
			'total' => number_format((int)str_replace(',', '', Cart::subtotal()) + $send_price),
			'tax' => number_format($send_price),
			'subtotal' => Cart::subtotal(),
			'free-ship' => $free_ship
		];

		$user = Auth::user();

		$cat = $this->mService->getCategories();
		$orders = $this->userService->getUserOrdersDetail($user->unique_id);

		return view('market.profile', compact('user', 'orders'))
			->withCart($cart)
			->withCategories($cat)
			->withAdmin($user->isAdmin());
	}

	public function orders(){
		$seller = Seller::where('unique_id', "vbkYwlL98I3F3")->firstOrFail();
		if (Cart::content()->count() > 0)
			$send_price = $seller->send_price;
		else
			$send_price = 0;

		if ((int)str_replace(',', '', Cart::subtotal()) > 30000) {
			$send_price = 0;
			$free_ship = true;
		} else
			$free_ship = false;

		$cart = [
			'items' => Cart::content(),
			'count' => Cart::content()->count(),
			'total' => number_format((int)str_replace(',', '', Cart::subtotal()) + $send_price),
			'tax' => number_format($send_price),
			'subtotal' => Cart::subtotal(),
			'free-ship' => $free_ship
		];

		$user = Auth::user();

		$cat = $this->mService->getCategories();
		$orders = $this->userService->getUserOrders($user->unique_id);

		return view('market.orders', compact('user', 'orders'))
			->withCart($cart)
			->withCategories($cat)
			->withAdmin($user->isAdmin());
	}
}