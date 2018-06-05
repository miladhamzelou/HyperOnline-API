<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Http\Controllers\v1\API;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use App\Jobs\SendSMS;
use App\Services\v1\UserService;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use phplusir\smsir\Smsir;

include(app_path() . '/Common/jdf.php');

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
					'error' => true,
					'tag' => 'validation',
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
						'error' => true,
						'tag' => $request->input('tag'),
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
		$orders = $this->Users->getUserOrdersDetail($id);
		return response()->json([
			'error' => false,
			'user' => $data,
			'orders' => $orders
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
				'error' => true,
				'tag' => 'validation',
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
					'c' => 'OK',
					'p' => $user->confirmed_phone
				], 201);
			else
				return response()->json([
					'error' => false,
					'c' => 'NOK',
					'p' => $user->confirmed_phone
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
			$user->update_date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());
			$user->save();

			SendEmail::dispatch([
				"to" => "hyper.online.h@gmail.com",
				"body" => "کاربر " . '* ' . $user->name . ' *' . " اطلاعات خود را تغییر داد. حساب کاربری نیاز به تایید دارد"
			], 0);

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

	public function resetPassword(Request $request)
	{
		$phone = $request->get("phone");
		$user = User::where("phone", $phone)->first();
		if ($user) {
			$password = $this->randomString(8, 0);
			SendSMS::dispatch([
				"msg" => ["هایپرآنلاین - رمز عبور جدید : " . $password],
				"phone" => [$phone]
			]);
			$hash = $this->hashSSHA($password);
			$user->encrypted_password = $hash["encrypted"];
			$user->password = $password;
			$user->salt = $hash["salt"];
			$user->update_date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());
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

	public function updatePassword(Request $request)
	{
		$id = $request->get("uid");
		$user = User::where("unique_id", $id)->first();
		if ($user) {
			$password = $request->get("password");
			$hash = $this->hashSSHA($password);
			$user->encrypted_password = $hash["encrypted"];
			$user->password = $password;
			$user->salt = $hash["salt"];
			$user->update_date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());
			$user->save();
			return response()->json([
				'error' => false
			], 201);
		} else
			return response()->json([
				'error' => true,
				'error_msg' => "چنین کاربری وجود ندارد"
			], 201);
	}

	private function randomString($length = 10, $hard)
	{
		$characters = '';
		if ($hard == 0)
			$characters = '0123456789';
		elseif ($hard == 1)
			$characters = '0123456789abc';
		else if ($hard == 2)
			$characters = '0123456789' . 'abcdefghijklmnopqrstuvwxyz';
		elseif ($hard == 3)
			$characters = '0123456789' . 'abcdefghijklmnopqrstuvwxyz' . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		elseif ($hard == 4)
			$characters = '0123456789' . 'abcdefghijklmnopqrstuvwxyz' . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' . '!@#$%&';
		$randomString = '';
		for ($i = 0; $i < $length; $i++)
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		return $randomString;
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

	public function syncID(Request $request)
	{
		try {
			$id = $request->get("u");
			$pushe = $request->get("p");
			$fireBase = $request->get("f");
			$user = User::where("unique_id", $id)->first();
			$user->pushe = $pushe;
			$user->fire = $fireBase;
			$user->update_date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());
			if (app('request')->exists('v')) {
				$version = $request->get("v");
				$user->android = $version;
			}
			$user->save();
			return response()->json([
				'error' => false
			], 201);
		} catch (Exception $e) {
			return response()->json([
				'error' => true,
				'error_msg' => $e
			], 201);
		}
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