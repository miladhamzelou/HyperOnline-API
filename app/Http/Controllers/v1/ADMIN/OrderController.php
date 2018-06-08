<?php
/**
 * Copyright (c) 2017 - All Rights Reserved - Arash Hatami
 */

/**
 * Created by PhpStorm.
 * User: root
 * Date: 8/14/17
 * Time: 6:18 PM
 */

namespace app\Http\Controllers\v1\ADMIN;


use App\Order;
use App\Pay;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

require(app_path() . '/Common/jdf.php');

class OrderController
{
	public function index()
	{
		if (!Auth::user()->isAdmin())
			return redirect()->route('profile');
		$orders = Order::orderBy("created_at", "desc")->get();

		return view('admin.orders')
			->withTitle("سفارشات")
			->withOrders($this->fix($orders));
	}

	public function pays()
	{
		if (!Auth::user()->isAdmin())
			return redirect()->route('profile');
		$pays = Pay::orderBy('created_at', 'desc')->get();
		return view('admin.pays')
			->withTitle("تراکنش ها")
			->withPays($pays);
	}

	public function details($id)
	{
		if (!Auth::user()->isAdmin())
			return redirect()->route('profile');
		$order = Order::find($id);
		$this->addInfo($order);
		if ($order->pay_way == "wallet") {
			$order->pay_way = "کیف پول";
			$order->wallet_price =  $this->formatMoney($order->price - $order->wallet_price);
		}
		$order->price = $this->formatMoney($order->price);
		$order->pay_method = ($order->pay_method == "online") ? "آنلاین" : "در محل";
		$user = User::where("unique_id", $order->user_id)->firstOrFail();
		$address = $user->state . ' - ' . $user->city . ' ///////// ' . $user->address;
		return view('admin.order_details')
			->withTitle("سفارش")
			->withAddress($address)
			->withOrder($order);
	}

	protected function fix($items)
	{
		foreach ($items as $item)
			$this->addInfo($item);
		return $this->fixPrice($items);
	}

	protected function addInfo(&$item)
	{
		$stuff = explode(',', $item->stuffs);
		$stuff_count = explode(',', $item->stuffs_count);
		$stuff_desc = explode(',', $item->stuffs_desc);
		$final = "";
		foreach (array_values($stuff) as $i => $value) {
			$final .= $value . ' ( ' . $stuff_desc[$i] . ' )( ' . $stuff_count[$i] . ' عدد ) :--: ';
		}
		$item->stuffs = substr($final, 0, -6);
	}

	protected function fixPrice($items)
	{
		foreach ($items as $item) {
			$item->price = $this->formatMoney($item->price);
			$item->price_send = $this->formatMoney($item->price_send);
		}

		return $items;
	}

	protected function formatMoney($number, $fractional = false)
	{
		if ($fractional)
			$number = sprintf('%.2f', $number);
		while (true) {
			$replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
			if ($replaced != $number)
				$number = $replaced;
			else
				break;
		}
		return $number;
	}

	public function downloadFactor($id)
	{
		$file = public_path() . "/ftp/factors/" . $id . ".pdf";
		$headers = array(
			'Content-Type: application/pdf',
		);
		return response()->download($file, $id . '.pdf', $headers);
	}

	public function sent($code)
	{
		$order = Order::where("code", $code)->first();
		$order->status = 'shipped';
		$order->save();

		$user = User::where("unique_id", $order->user_id)->first();

		$client = new Client([
			'headers' => [
				'Authorization' => 'Token 49a07ca7cb6a25c2d61044365c4560500a38ec3f',
				'Content-Type' => 'application/json',
				'Accept: application/json'
			]
		]);
		$response = $client->post(
			'https://panel.pushe.co/api/v1/notifications/',
			[
				'body' => json_encode([
					"applications" => ["ir.hatamiarash.hyperonline"],
					"filter" => [
						"imei" => [$user->pushe]
					],
					"notification" => [
						"title" => "سفارش",
						"content" => "سفارش شما ارسال شد",
						"wake_screen" => true,
						"action" => [
							"action_data" => "Activity_Inbox",
							"action_type" => "T"
						],
					],
					"custom_content" => [
						"type" => "1",
						"msg" => [
							"title" => "سفارش",
							"body" => "سفارش شما با کد " . $code . " ارسال شد.",
							"date" => $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime())
						]
					]
				])
			]
		);
		if ($response->getStatusCode() == "201") {
			return redirect('/admin/orders/' . $order->unique_id)
				->withMessage("پیغام ارسال شد");
		} else
			return redirect('/admin/orders/' . $order->unique_id)
				->withErrors("خطایی رخ داده است");
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