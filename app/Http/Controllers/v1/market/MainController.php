<?php

namespace App\Http\Controllers\v1\MARKET;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use App\Jobs\SendSMS;
use App\Order;
use App\Pay;
use App\Product;
use App\Seller;
use App\Services\v1\market\MainService;
use App\User;
use DateTime;
use DateTimeZone;
use Gloudemans\Shoppingcart\Facades\Cart;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

require(app_path() . '/Common/jdf.php');

class MainController extends Controller
{
	protected $mService;

	public function __construct(MainService $service)
	{
		$this->mService = $service;
	}

	public function index()
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

		$isAdmin = 0;

		if (Auth::check())
			if (Auth::user()->isAdmin() == 1)
				$isAdmin = 1;

		$new = $this->mService->getNew();
		$cat = $this->mService->getCategories();
		$most = $this->mService->getMostSell();
		$cat1 = $this->mService->getRandomCategory();
		$cat2 = $this->mService->getRandomCategory();
		$cat3 = $this->mService->getRandomCategory2();
		$off = $this->mService->getOff();

		return view('market.home')
			->withNew($new)
			->withCategories($cat)
			->withCart($cart)
			->withMost($most)
			->withRand1($cat1)
			->withRand2($cat2)
			->withRand3($cat3)
			->withOff($off)
			->withAdmin($isAdmin);
	}

	public function checkout()
	{
		$seller = Seller::where('unique_id', "vbkYwlL98I3F3")->firstOrFail();
		if (Cart::content()->count() > 0)
			$send_price = $seller->send_price;
		else
			$send_price = 0;
		$isAdmin = 0;

		if ((int)str_replace(',', '', Cart::subtotal()) > 30000) {
			$send_price = 0;
			$free_ship = true;
		} else
			$free_ship = false;

		if (Auth::check())
			if (Auth::user()->isAdmin() == 1)
				$isAdmin = 1;

		$cat = $this->mService->getCategories();

		$cart = [
			'items' => Cart::content(),
			'count' => Cart::content()->count(),
			'total' => number_format((int)str_replace(',', '', Cart::subtotal()) + $send_price),
			'tax' => number_format($send_price),
			'subtotal' => Cart::subtotal(),
			'free-ship' => $free_ship
		];

		return view('market.checkout')
			->withCategories($cat)
			->withAdmin($isAdmin)
			->withCart($cart);
	}

	public function pay_confirm(Request $request)
	{
		$way = $request->get('pay_way');
		if ($way == 1) {
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

			$isAdmin = 0;

			if (Auth::user()->isAdmin() == 1)
				$isAdmin = 1;

			$final_pay = (int)str_replace(',', '', Cart::subtotal()) + $send_price;

			$user = Auth::user();
			$confirmed = $user->confirmed_phone && $user->confirmed_info;

			$data = [
				'confirmed' => $confirmed,
				'user' => $user,
				'pay' => $final_pay
			];

			$cat = $this->mService->getCategories();

			$cart = [
				'items' => Cart::content(),
				'count' => Cart::content()->count(),
				'total' => number_format((int)str_replace(',', '', Cart::subtotal()) + $send_price),
				'tax' => number_format($send_price),
				'subtotal' => Cart::subtotal(),
				'free-ship' => $free_ship
			];

			return view('market.confirm')
				->withData($data)
				->withCart($cart)
				->withCategories($cat)
				->withAdmin($isAdmin);
		} else {
			$items = Cart::content();

			$stuffs = "";
			$stuffs_id = "";
			$stuffs_count = "";

			foreach ($items as $item) {
				$stuffs .= $item->name;
				$stuffs_id .= $item->id;
				$stuffs_count .= $item->qty;
			}

			$order = new Order();
			$user = Auth::user();
			$seller = Seller::where('unique_id', "vbkYwlL98I3F3")->firstOrFail();
			$send_price = $seller->send_price;

			$order->unique_id = uniqid('', false);
			$order->seller_id = $seller->unique_id;
			$order->user_id = $user->unique_id;
			$order->code = $order->unique_id;
			$order->seller_name = $seller->name;
			$order->user_name = $user->name;
			$order->user_phone = $user->phone;
			$order->stuffs = ltrim(rtrim($stuffs, ','), ',');
			$order->stuffs_id = ltrim(rtrim($stuffs_id, ','), ',');
			$order->stuffs_count = ltrim(rtrim($stuffs_count, ','), ',');
			$order->price_send = $send_price;
			$order->hour = $this->getOrderHour();
			$order->pay_method = 'place';
			$order->create_date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());

			$ids = explode(',', $order->stuffs_id);
			$products = array();
			foreach ($ids as $id) {
				$p = Product::where("unique_id", $id)->firstOrFail()->toArray();
				array_push($products, $p);
			}
			$price_original = 0;
			$tOff = 0;
			$tFinal = 0;
			$counts = explode(',', $order->stuffs_count);
			$desc = '';
			foreach ($products as $index => $pr) {
				$product = Product::where("unique_id", $pr['unique_id'])->firstOrFail();

				if ($order->user_phone != '09123456789' && $order->user_phone != '09182180519' && $order->user_phone != '09182180520') {
					$product->sell = $product->sell + 1;
					$product->count = $product->count - 1;
				}
				if ($product->description)
					$desc .= $product->description . ',';
				else
					$desc .= '-,';

				$price_original += $product->price_original * $counts[$index];
				$tOff += $product->price * $product->off / 100 * $counts[$index];
				$tFinal += ($product->price - ($product->price * $product->off / 100)) * $counts[$index];

				$product->save();
			}

			if ($tFinal < 30000) $tFinal += $send_price;
			$order->price = $tFinal;
			$order->price_original = $price_original;
			$order->stuffs_desc = ltrim(rtrim($desc, ','), ',');
			$order->temp = 1;
			$order->save();

			$this->addInfo($order);

			$data = [
				"products" => $products,
				"counts" => $counts,
				"desc" => explode(',', $order->stuffs_desc),
				"user_name" => $order->user_name,
				"user_phone" => $order->user_phone,
				"user_code" => $user->code,
				"user_address" => $user->state . '-' . $user->city . ' : ' . $user->address,
				"total" => $tFinal + $tOff - $send_price,
				"off" => $tOff,
				"final" => $tFinal,
				"hour" => $order->hour,
				"description" => $order->description,
				"date" => $order->create_date,
				"code" => $order->code,
				"send_price" => $send_price
			];
			$pdf = PDF::loadView('pdf.factor', $data);
			$pdf->save(public_path('/ftp/factors/' . $order->code . '.pdf'));

			$type = "حضوری";

			SendEmail::dispatch([
				"to" => "hyper.online.h@gmail.com",
				"body" => "سفارش ( " . $type . " )( سایت ) جدید ثبت شد",
				"order" => [
					"code" => $order->code,
					"user_name" => $order->user_name,
					"user_phone" => $order->user_phone,
					"stuffs" => $order->stuffs,
					"hour" => $order->hour,
					"price" => $order->price,
					"desc" => $order->description,
					"address" => $user->address
				]
			], 1)
				->onQueue('email');

			if ($order->user_phone != '09182180519')
				SendSMS::dispatch([
					"msg" => ["سفارش ( " . $type . " ) جدید ثبت شد"],
					"phone" => ["09188167800"]
				])
					->onQueue('sms');

			$data = [
				"products" => $products,
				"counts" => $counts,
				"user_name" => $order->user_name,
				"user_phone" => $order->user_phone,
				"user_address" => $user->address,
				"total" => $order->price,
				"hour" => $order->hour,
				"description" => $order->description
			];

			$mService = new MainService();
			$cat = $mService->getCategories();

			if (Cart::content()->count() > 0)
				$send_price = $seller->send_price;
			else
				$send_price = 0;
			if ((int)str_replace(',', '', Cart::subtotal()) > 30000) {
				$send_price = 0;
				$free_ship = true;
			} else
				$free_ship = false;

			$isAdmin = 0;
			if (Auth::check())
				if (Auth::user()->isAdmin() == 1)
					$isAdmin = 1;

			$cart = [
				'items' => Cart::content(),
				'count' => Cart::content()->count(),
				'total' => number_format((int)str_replace(',', '', Cart::subtotal()) + $send_price),
				'tax' => number_format($send_price),
				'subtotal' => Cart::subtotal(),
				'free-ship' => $free_ship
			];

			Cart::destroy();

			return view('market.result')
				->withData($data)
				->withOrder($order)
				->withCategories($cat)
				->withAdmin($isAdmin)
				->withCart($cart);
		}
	}

	public function pay()
	{
		$client = new Client();
		try {
			$res = $client->request(
				'POST',
				'https://pay.ir/payment/send',
				[
					'json' => [
						'api' => config('pay.api-key'),
						'amount' => '1000',
						'redirect' => "http://hyper-online.ir/callback2",
						'factorNumber' => '1'
					]
				]);
			$transId = json_decode($res->getBody(), true)['transId'];
		} catch (GuzzleException $ignore) {
		}
		return redirect('https://pay.ir/payment/gateway/' . $transId);
	}

	public function callback(Request $request)
	{
		$pay = new Pay();
		if (app('request')->exists('status')) $pay->status = $request->input('status');
		if (app('request')->exists('transId')) $pay->transId = $request->input('transId');
		if (app('request')->exists('factorNumber')) $pay->factorNumber = $request->input('factorNumber');
		if (app('request')->exists('cardNumber')) $pay->cardNumber = $request->input('cardNumber');
		if (app('request')->exists('message')) $pay->message = $request->input('message');
		$pay->save();

		$cat = $this->mService->getCategories();

		$client = new Client();
		try {
			$res = $client->request(
				'POST',
				'https://pay.ir/payment/verify',
				[
					'json' => [
						'api' => config('pay.api-key'),
						'transId' => $pay->transId
					]
				]);
		} catch (GuzzleException $ignore) {
		}
		$status = json_decode($res->getBody(), true)['status'];

		if ($status == 1) {
			$this->setOrder($pay->transId);
			$result = "پرداخت انجام شد";
		} else
			$result = "مشکلی رخ داده است";

		$cart = [
			'items' => Cart::content(),
			'count' => Cart::content()->count(),
			'total' => Cart::total(),
			'tax' => Cart::tax(),
			'subtotal' => Cart::subtotal()
		];

		$isAdmin = 0;

		if (Auth::check())
			if (Auth::user()->isAdmin() == 1)
				$isAdmin = 1;

		return view('market.report')
			->withCategories($cat)
			->withCart($cart)
			->withAdmin($isAdmin)
			->withResult($result);
	}

	protected function setOrder($code)
	{
		$content = Cart::content();
		$total = Cart::total();
		$user = User::where('unique_id', Auth::user()->unique_id)->firstOrFail();
		$seller = Seller::firstOrFail();

		$stuffs = "";
		$stuffs_id = "";
		$stuffs_count = "";
		foreach ($content as $item) {
			$stuffs .= ',' . $item->name;
			$stuffs_id .= ',' . $item->id;
			$stuffs_count .= ',' . $item->qty;
		}


		$order = new Order();
		$order->unique_id = uniqid('', false);
		$order->seller_id = $seller->unique_id;
		$order->user_id = $user->unique_id;
		$order->code = $code;
		$order->seller_name = $seller->name;
		$order->user_name = $user->name;
		$order->user_phone = $user->phone;
		$order->stuffs = ltrim(rtrim($stuffs, ','), ',');
		$order->stuffs_id = ltrim(rtrim($stuffs_id, ','), ',');
		$order->stuffs_count = ltrim(rtrim($stuffs_count, ','), ',');
		$order->price_send = 5000;
		$order->hour = $this->calcTime();
		$order->pay_method = 'online';
		$order->description = "";
		$order->create_date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());

		$ids = explode(',', $order->stuffs_id);
		$products = array();
		foreach ($ids as $id) {
			$p = Product::where("unique_id", $id)->firstOrFail()->toArray();
			array_push($products, $p);
		}
		$price_original = 0;
		$tPrice = 0;
		$counts = explode(',', $order->stuffs_count);
		foreach ($products as $index => $pr) {
			$product = Product::where("unique_id", $pr['unique_id'])->firstOrFail();
			$product->sell = $product->sell + 1;
//            $product->count = $product->count - 1;
			$price_original += $product->price_original * $counts[$index];
			$tPrice += $product->price * $counts[$index];
			$product->save();
		}
		if ($tPrice < 30000) $tPrice += 5000;
		$order->price = $tPrice;
		$order->price_original = $price_original;
		$order->save();

		$data = [
			"products" => $products,
			"counts" => $counts,
			"user_name" => $order->user_name,
			"user_phone" => $order->user_phone,
			"user_address" => User::where("unique_id", $order->user_id)->firstOrFail()->address,
			"total" => $order->price,
			"hour" => $order->hour,
			"description" => $order->description
		];
		$pdf = PDF::loadView('pdf.factor', $data);
		$pdf->save(public_path('/ftp/factors/' . $order->code . '.pdf'));

		Cart::destroy();
	}

	protected function calcTime()
	{
		$hour = date("H", time());
		$minute = date("m", time());
		$send_time = 0;

		if ($hour >= 9 && $hour < 10)
			if ($minute <= 40)
				$send_time = 9;
			else
				$send_time = 11;
		if ($hour >= 10 && $hour < 11) $send_time = 2;
		if ($hour >= 11 && $hour < 12)
			if ($minute <= 40)
				$send_time = 11;
			else
				$send_time = 16;
		if ($hour >= 12 && $hour < 16) $send_time = 3;
		if ($hour >= 16 && $hour < 17)
			if ($minute <= 40)
				$send_time = 16;
			else
				$send_time = 18;
		if ($hour >= 17 && $hour < 18) $send_time = 4;
		if ($hour >= 18 && $hour < 19)
			if ($minute <= 40)
				$send_time = 18;
			else
				$send_time = 9;
		if ($hour >= 19 && $hour <= 23) $send_time = 9;
		if ($hour >= 0 && $hour < 9) $send_time = 9;
		return $send_time;
	}

	public function contact_us()
	{
		$isAdmin = 0;
		if (Auth::check())
			if (Auth::user()->isAdmin() == 1)
				$isAdmin = 1;
		$cat = $this->mService->getCategories();

		if ((int)str_replace(',', '', Cart::subtotal()) > 30000) {
			$free_ship = true;
		} else
			$free_ship = false;

		$cart = [
			'items' => Cart::content(),
			'count' => Cart::content()->count(),
			'total' => Cart::total(),
			'tax' => Cart::tax(),
			'subtotal' => Cart::subtotal(),
			'free-ship' => $free_ship
		];
		return view('market.contact_us')
			->withCategories($cat)
			->withAdmin($isAdmin)
			->withCart($cart);
	}

	public function about()
	{
		$isAdmin = 0;
		if (Auth::check())
			if (Auth::user()->isAdmin() == 1)
				$isAdmin = 1;
		$cat = $this->mService->getCategories();

		if ((int)str_replace(',', '', Cart::subtotal()) > 30000) {
			$free_ship = true;
		} else
			$free_ship = false;

		$cart = [
			'items' => Cart::content(),
			'count' => Cart::content()->count(),
			'total' => Cart::total(),
			'tax' => Cart::tax(),
			'subtotal' => Cart::subtotal(),
			'free-ship' => $free_ship
		];
		return view('market.about')
			->withCategories($cat)
			->withAdmin($isAdmin)
			->withCart($cart);
	}

	public function privacy()
	{
		$isAdmin = 0;
		if (Auth::check())
			if (Auth::user()->isAdmin() == 1)
				$isAdmin = 1;
		$cat = $this->mService->getCategories();

		if ((int)str_replace(',', '', Cart::subtotal()) > 30000) {
			$free_ship = true;
		} else
			$free_ship = false;

		$cart = [
			'items' => Cart::content(),
			'count' => Cart::content()->count(),
			'total' => Cart::total(),
			'tax' => Cart::tax(),
			'subtotal' => Cart::subtotal(),
			'free-ship' => $free_ship
		];
		return view('market.privacy')
			->withCategories($cat)
			->withAdmin($isAdmin)
			->withCart($cart);
	}

	public function terms()
	{
		$isAdmin = 0;
		if (Auth::check())
			if (Auth::user()->isAdmin() == 1)
				$isAdmin = 1;
		$cat = $this->mService->getCategories();

		if ((int)str_replace(',', '', Cart::subtotal()) > 30000) {
			$free_ship = true;
		} else
			$free_ship = false;

		$cart = [
			'items' => Cart::content(),
			'count' => Cart::content()->count(),
			'total' => Cart::total(),
			'tax' => Cart::tax(),
			'subtotal' => Cart::subtotal(),
			'free-ship' => $free_ship
		];
		return view('market.terms')
			->withCategories($cat)
			->withAdmin($isAdmin)
			->withCart($cart);
	}

	public function comment()
	{
		$isAdmin = 0;
		if (Auth::check())
			if (Auth::user()->isAdmin() == 1)
				$isAdmin = 1;
		$cat = $this->mService->getCategories();

		if ((int)str_replace(',', '', Cart::subtotal()) > 30000) {
			$free_ship = true;
		} else
			$free_ship = false;

		$cart = [
			'items' => Cart::content(),
			'count' => Cart::content()->count(),
			'total' => Cart::total(),
			'tax' => Cart::tax(),
			'subtotal' => Cart::subtotal(),
			'free-ship' => $free_ship
		];
		return view('market.comment')
			->withCategories($cat)
			->withAdmin($isAdmin)
			->withCart($cart);
	}

	public function sendComment(Request $request)
	{
		$validator = Validator::make(
			$request->all(),
			[
				'g-recaptcha-response' => 'required|captcha'
			],
			[
				'required' => 'لطفا هویت خود را تایید کنید.',
				'captcha' => 'خطایی رخ داده است. مجدد امتحان کرده یا با پشتیبانی تماس بگیرید.',
			]
		);

		if (!$validator->fails()) {
			$comment = new Comment();
			$comment->unique_id = uniqid('', false);
			if (Auth::check())
				$user = User::find(Auth::user()->getID());
			else
				$user = User::where("role", "admin")->first();
			$comment->user_id = $user->unique_id;
			$comment->user_name = $user->name;
			if ($user->image)
				$comment->user_image = $user->image;
			$comment->body = $request->get('body');
			$comment->create_date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());
			$comment->save();
			SendEmail::dispatch([
				"to" => "hyper.online.h@gmail.com",
				"body" => "نظر جدید در سایت ثبت شد"
			], 0)
				->onQueue('email');
			return redirect('/');
		} else {
			return back()->withErrors(['g-recaptcha-response' => ['لطفا هویت خود را تایید کنید']]);
		}
	}

	private function getOrderHour()
	{
		$date = new DateTime();
		$date->setTimeZone(new DateTimeZone("Asia/Tehran"));
		$hour = $date->format('H');
		$minute = $date->format('i');
		$send_time = 9;

		if ($hour >= 9 && $hour < 10) $send_time = 11;
		if ($hour >= 10 && $hour < 11)
			if ($minute <= 40)
				$send_time = 11;
			else
				$send_time = 16;

		if ($hour >= 11 && $hour < 15) $send_time = 16;
		if ($hour >= 15 && $hour < 16)
			if ($minute <= 40)
				$send_time = 16;
			else
				$send_time = 18;

		if ($hour >= 16 && $hour < 17) $send_time = 18;
		if ($hour >= 17 && $hour < 18)
			if ($minute <= 40)
				$send_time = 18;
			else
				$send_time = 19;

		if ($hour >= 18 && $hour < 19)
			if ($minute <= 50)
				$send_time = 19;
			else
				$send_time = 9;

		if ($hour >= 19 && $hour <= 23) $send_time = 9;
		if ($hour >= 0 && $hour < 8) $send_time = 9;
		if ($hour >= 8 && $hour < 9)
			if ($minute <= 40)
				$send_time = 9;
			else
				$send_time = 11;

		return $send_time;
	}

	public function addInfo(&$item)
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