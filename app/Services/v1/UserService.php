<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Services\v1;

use App\Jobs\SendEmail;
use App\Order;
use App\Password;
use App\Presenter;
use App\User;
use App\Wallet;
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

include(app_path() . '/Common/jdf.php');

class UserService
{
	protected $clauseProperties = [
		'unique_id'
	];

	/**
	 * @param $parameters
	 * @return array
	 */
	public function getUsers($parameters)
	{
		if (empty($parameters))
			return $this->filterUsers(User::all());

		$whereClauses = $this->getWhereClauses($parameters);

		$users = User::where($whereClauses)->get();

		return $this->filterUsers($users);
	}

	public function getUser($id)
	{
		$user = User::where('unique_id', $id)->firstOrFail();

		$final = [
			'unique_id' => $user->unique_id,
			'name' => $user->name,
			'code' => $user->code,
			'image' => $user->image,
			'phone' => $user->phone,
			'address' => $user->address,
			'wallet' => $user->wallet->price,
			'state' => $user->state,
			'city' => $user->city,
			'confirmed_phone' => $user->confirmed_phone
		];

		return $final;
	}

	/**
	 * return details of all user's orders
	 * @param $id
	 * @return array
	 */
	public function getUserOrdersDetail($id)
	{
		$orders = Order::whereUserId($id)->whereIn('status', ['delivered', 'shipped', 'pending'])->get();

		$totalPrice = 0;
		$totalCount = 0;
		$totalPlace = 0;
		$totalOnline = 0;

		foreach ($orders as $order) {
			if ($order->pay_method == "place") {
				$totalPrice += $order->price;
				$totalCount++;
				$totalPlace++;
			} else {
				if (!$order->temp) {
					$totalPrice += $order->price;
					$totalCount++;
					$totalOnline++;
				}
			}
		}

		return [
			'totalPrice' => $totalPrice,
			'totalCount' => $totalCount,
			'totalPlace' => $totalPlace,
			'totalOnline' => $totalOnline
		];
	}

	/**
	 * return details of all user's orders
	 * @param $id
	 * @return array
	 */
	public function getUserOrders($id)
	{
		$orders = Order::whereUserId($id)->whereIn('status', ['delivered', 'shipped', 'pending'])->orderBy('created_at', 'desc')->get();
		return $orders;
	}

	/**
	 * @param $request
	 * @return boolean
	 */
	public function createUser($request)
	{
		$user = new User();
		$password = new Password();
		$date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());


		$user->unique_id = uniqid('', false);
		$hash = $this->hashSSHA($request->input('password'));
		$user->encrypted_password = $hash["encrypted"];
		$user->password = $request->input('password');
		$user->salt = $hash["salt"];
		$user->name = $request->input('name');

		$count = count(User::get()) + 1;
		$user->code = "HO-" . $count;

		$user->phone = $request->input('phone');
		$user->address = $request->input('address');
		$user->state = $request->input('state');
		$user->city = $request->input('city');
		if (app('request')->exists('location_x')) $user->location_x = $request->input('location_x');
		if (app('request')->exists('location_y')) $user->location_y = $request->input('location_y');
		$user->create_date = $date;
		$user->confirmed_phone = 0;
		$user->confirmed_info = 1;

		$password->unique_id = uniqid('', false);
		$password->user_id = $user->unique_id;
		$password->name = $user->name;
		$password->phone = $user->phone;
		if (app('request')->exists('email')) $password->email = $user->email;
		$password->password = $request->input('password');
		$password->create_date = $date;

		$user->save();
		$password->save();

		if (app('request')->exists('presenter')) {
			$phone = $request->input('presenter');
			$oldUser = User::where('phone', $phone)->first();
			if ($oldUser && ($user->phone != $phone)) {
				$oldPresent = Presenter::where('user_id', $user->unique_id)->where('presenter_id', $oldUser->unique_id)->first();
				if (!$oldPresent) {
					$presenter = new Presenter();
					$presenter->unique_id = uniqid('', false);
					$presenter->user_id = $user->unique_id;
					$presenter->presenter_id = $oldUser->unique_id;
					$presenter->create_date = $date;
					$presenter->save();
				}
			}
		}

		$wallet = new Wallet();
		$wallet->unique_id = uniqid('', true);
		$wallet->user_id = $user->unique_id;
		$wallet->code = "HO-" . strval(mt_rand(100, 999)) . strval(Wallet::count() + 151);
		$wallet->create_date = $date;
		$wallet->status = 'active';
		$wallet->save();

		$QRCode = new BaconQrCodeGenerator;
		$file = public_path('/images/qr/' . $wallet->code . '.png');
		$QRCode->encoding('UTF-8')
			->format('png')
			->merge('/public/market/image/h_logo.png', .15)
			->size(1000)
			->generate($wallet->unique_id, $file);

		SendEmail::dispatch([
			"to" => "hyper.online.h@gmail.com",
			"body" => "کاربر " . '* ' . $user->name . ' *' . " ثبت نام کرد. حساب کاربری نیاز به تایید دارد"
		], 0);

		return true;
	}

	/**
	 * @param $request
	 * @return array|bool
	 */
	public function checkUser($request)
	{
		$user = User::where('phone', $request->input('phone'))->firstOrFail();
		$hash = $this->checkHashSSHA($user->salt, $request->input('password'));
		if ($hash == $user->encrypted_password) {
			$final = [
				'unique_id' => $user->unique_id,
				'name' => $user->name,
				'code' => $user->code,
				'image' => $user->image,
				'phone' => $user->phone,
				'address' => $user->address,
				'wallet' => $user->wallet,
				'state' => $user->state,
				'city' => $user->city,
				'confirmed_phone' => $user->confirmed_phone,
				'confirmed_info' => $user->confirmed_info
			];
			return $final;
		} else
			return false;
	}

	/**
	 * @param $request
	 * @param $id
	 * @return bool
	 */
	public function updateUser($request, $id)
	{
		$user = User::where('unique_id', $id)->firstOrFail();

		if (app('request')->exists('address')) $user->address = $request->input('address');

		$user->update_date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());
		$user->save();

		return true;
	}

	public function deleteUser($id)
	{
		try {
			$user = User::where('unique_id', $id)->firstOrFail();
			$user->delete();
		} catch (\Exception $ignore) {
		}
	}

	public function checkExists($request)
	{
		$user = User::where("phone", $request->get('phone'))->first();
		if ($user)
			return true;
		else
			return false;
	}


	/**
	 * @param $users
	 * @return array
	 */
	protected function filterUsers($users)
	{
		$data = [];

		foreach ($users as $user) {
			$entry = [
				'unique_id' => $user->unique_id,
				'name' => $user->name,
				'code' => $user->code,
				'image' => $user->image,
				'phone' => $user->phone,
				'address' => $user->address,
				'wallet' => $user->wallet,
				'state' => $user->state,
				'city' => $user->city,
				'confirmed_phone' => $user->confirmed_phone
			];

			$data[] = $entry;
		}
		return $data;
	}

	/**
	 * @param $parameters
	 * @return array
	 */
	protected function getWhereClauses($parameters)
	{
		$clause = [];

		foreach ($this->clauseProperties as $prop)
			if (in_array($prop, array_keys($parameters)))
				$clause[$prop] = $parameters[$prop];

		return $clause;
	}

	/**
	 * @param $password
	 * @return array
	 */
	public function hashSSHA($password)
	{
		$salt = sha1(rand());
		$salt = substr($salt, 0, 10);
		$encrypted = base64_encode(sha1($password . $salt, true) . $salt);
		$hash = array("salt" => $salt, "encrypted" => $encrypted);
		return $hash;
	}

	/**
	 * @param $salt
	 * @param $password
	 * @return string
	 */
	public function checkHashSSHA($salt, $password)
	{
		$hash = base64_encode(sha1($password . $salt, true) . $salt);
		return $hash;
	}

	protected function getCurrentTime()
	{
		$now = date("Y-m-d", time());
		$time = date("H:i:s", time());
		return $now . ' ' . $time;
	}

	protected function getDate($date)
	{
		$now = explode(' ', $date)[0];
		$time = explode(' ', $date)[1];
		list($year, $month, $day) = explode('-', $now);
		list($hour, $minute, $second) = explode(':', $time);
		$timestamp = mktime($hour, $minute, $second, $month, $day, $year);
		$date = jDate("Y/m/d", $timestamp);
		return $date;
	}

	protected function getTime($date)
	{
		$now = explode(' ', $date)[0];
		$time = explode(' ', $date)[1];
		list($year, $month, $day) = explode('-', $now);
		list($hour, $minute, $second) = explode(':', $time);
		$timestamp = mktime($hour, $minute, $second, $month, $day, $year);
		$date = jDate("H:i", $timestamp);
		return $date;
	}
}