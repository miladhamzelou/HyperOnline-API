<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

namespace App\Http\Controllers\v1\ADMIN;

use App\Http\Controllers\Controller;
use App\Presenter;
use App\Push;
use App\Services\v1\UserService;
use App\User;
use App\Wallet;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
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
		if (!Auth::user()->isAdmin())
			return redirect()->route('profile');
		$users = User::orderBy("created_at", "desc")->get();
		return view('admin.users')
			->withTitle("کاربران")
			->withUsers($users);
	}

	public function info($id)
	{
		if (!Auth::user()->isAdmin())
			return redirect()->route('profile');
		$user = User::where("unique_id", $id)->firstOrFail();
		if ($user->role == "admin") $user->role = "مدیر";
		if ($user->role == "user") $user->role = "کاربر";
		if ($user->role == "developer") $user->role = "توسعه دهنده";
		$user->create_date = str_replace(":", " : ", $user->create_date);


		$presenter = Presenter::where("user_id", $id)->first();
		$presenterUser = "null";
		if ($presenter) {
			$presenterUser = User::where("unique_id", $presenter->presenter_id)->first();
		}


		return view('admin.user_view')
			->withTitle($user->name)
			->withUser($user)
			->withPresenter($presenterUser);
	}

	public function chargeWallet(Request $request)
	{
		$price = $request->get('price');
		$id = $request->get('id');

		$user = User::where("unique_id", $id)->first();
		$wallet = Wallet::where("user_id", $id)->first();

		$wallet->price = (int)$wallet->price + (int)$price;
		$wallet->save();

		$client = new Client([
			'headers' => [
				'Authorization' => 'Token ' . config('pushe.api-key'),
				'Content-Type' => 'application/json',
				'Accept: application/json'
			]
		]);

		$title = "کیف پول";
		$body = "کیف پول شما" . $price . "تومان شارژ شد";

		$response = $client->post(
			config('pushe.api'),
			[
				'body' => json_encode([
					"applications" => ["ir.hatamiarash.hyperonline"],
					"filter" => [
						"imei" => [$user->pushe]
					],
					"notification" => [
						"title" => $title,
						"content" => $body,
						"wake_screen" => true,
						"action" => [
							"action_data" => "Activity_Inbox",
							"action_type" => "T"
						],
					],
					"custom_content" => [
						"type" => "1",
						"msg" => [
							"title" => $title,
							"body" => $body,
							"date" => $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime())
						]
					]
				])
			]
		);

		if ($response->getStatusCode() == "201") {
			$push = new Push();
			$push->title = $title;
			$push->body = $body;
			$push->save();

			$message = "کیف پول شارژ و پیام ارسال شد";
			return redirect('/admin/users')
				->withMessage($message);
		} else {
			$message = "پیام ارسال نشد";
			return redirect('/admin/users')
				->withMessage($message);
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