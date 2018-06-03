<?php
/**
 * Created by PhpStorm.
 * User: hatamiarash7
 * Date: 2018-05-25
 * Time: 20:32
 */

namespace App\Http\Controllers\v1\API;


use App\Facades\CustomLog;
use App\Http\Controllers\Controller;
use App\Order;
use App\Pay;
use App\Transaction;
use App\Transfer;
use App\User;
use App\Wallet;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

include(app_path() . '/Common/jdf.php');

class WalletController extends Controller
{
	protected $API;

	public function __construct()
	{
		$this->API = "4d0d3be84eae7fbe5c317bf318c77e83";
	}

	public function getWalletByUser($id)
	{
		$user = User::where('unique_id', $id)->first();
		if ($user)
			return response()->json([
				'error' => false,
				'wallet' => $user->wallet,
				'orders' => $this->getWalletOrders($id)
			], 201);
		else
			return response()->json([
				'error' => true,
				'error_msg' => "مشکلی پیش آمده است"
			], 201);
	}

	public function getWalletByID($id)
	{
		$wallet = Wallet::where('unique_id', $id)->first();
		if ($wallet)
			return response()->json([
				'error' => false,
				'wallet' => $wallet,
				'orders' => $this->getWalletOrders($wallet->user->unique_id)
			], 201);
		else
			return response()->json([
				'error' => true,
				'error_msg' => "مشکلی پیش آمده است"
			], 201);
	}

	public function getWalletCode(Request $request)
	{
		$id = $request->get('unique_id');
		$wallet = Wallet::where('unique_id', $id)->first();
		if ($wallet)
			return response()->json([
				'error' => false,
				'code' => $wallet->code,
			], 201);
		else
			return response()->json([
				'error' => true,
				'error_msg' => "مشکلی پیش آمده است"
			], 201);
	}

	private function getWalletOrders($user_id)
	{
		$orders = Order::whereUserId($user_id)->get();
		$count = 0;
		$price = 0;
		foreach ($orders as $order) {
			if ($order->temp == 1) {
				if ($order->pay_method == 'place') {
					$count++;
					$price += $order->wallet_price;
				}
			} else {
				$count++;
				$price += $order->wallet_price;
			}
		}
		return [
			'count' => $count,
			'price' => $price
		];
	}

	public function getTransferConfirmationByID(Request $request)
	{
		$user = User::where('unique_id', $request->get('user_id'))->first();
		$src_wallet = Wallet::where('unique_id', $request->get('src_id'))->first();
		$des_wallet = Wallet::where('unique_id', $request->get('dest_id'))->first();

		if ($user && $src_wallet && $des_wallet) {
			if ($src_wallet->status != 'active')
				return response()->json([
					'error' => true,
					'error_msg' => 'کیف پول شما فعال نیست'
				], 201);
			elseif ($des_wallet->status != 'active')
				return response()->json([
					'error' => true,
					'error_msg' => 'کیف پول مقصد فعال نیست'
				], 201);
			else {
				return response()->json([
					'error' => false,
					'user' => $des_wallet->user->name,
					'wallet' => $des_wallet->code,
					'price' => $src_wallet->price
				], 201);
			}
		} else {
			return response()->json([
				'error' => true,
				'error_msg' => 'مشکلی به وجود آمده است'
			], 201);
		}
	}

	public function getTransferConfirmationByCode(Request $request)
	{
		$user = User::where('unique_id', $request->get('user_id'))->first();
		$src_wallet = Wallet::where('code', 'HO-' . $request->get('src_code'))->first();
		$des_wallet = Wallet::where('code', 'HO-' . $request->get('dest_code'))->first();

		if ($user && $src_wallet && $des_wallet) {
			if ($src_wallet->status != 'active')
				return response()->json([
					'error' => true,
					'error_msg' => 'کیف پول شما فعال نیست'
				], 201);
			elseif ($des_wallet->status != 'active')
				return response()->json([
					'error' => true,
					'error_msg' => 'کیف پول مقصد فعال نیست'
				], 201);
			else {
				return response()->json([
					'error' => false,
					'user' => $des_wallet->user->name,
					'price' => $src_wallet->price
				], 201);
			}
		} else {
			return response()->json([
				'error' => true,
				'error_msg' => 'مشکلی به وجود آمده است'
			], 201);
		}
	}

	public function transferMoney(Request $request)
	{
		$price = $request->get('price');

		$user = User::where('unique_id', $request->get('user_id'))->first();
		$src_wallet = Wallet::where('code', 'HO-' . $request->get('src_code'))->first();
		$des_wallet = Wallet::where('code', 'HO-' . $request->get('dest_code'))->first();

		if ($user && $src_wallet && $des_wallet) {
			if ($src_wallet->status != 'active')
				return response()->json([
					'error' => true,
					'error_msg' => 'کیف پول شما فعال نیست'
				], 201);
			elseif ($des_wallet->status != 'active')
				return response()->json([
					'error' => true,
					'error_msg' => 'کیف پول مقصد فعال نیست'
				], 201);
			else {
				if ((int)$src_wallet->price >= (int)$price) {
					$src_wallet->price = (int)$src_wallet->price - (int)$price;
					$src_wallet->save();
					$des_wallet->price = (int)$des_wallet->price + (int)$price;
					$des_wallet->save();

					$date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());

					$unique = uniqid('', false);
					$transaction1 = new Transaction();
					$transaction1->unique_id = $unique;
					$transaction1->user_id = $user->unique_id;
					$transaction1->wallet_id = $src_wallet->unique_id;
					$transaction1->price = $price;
					$transaction1->code = $unique;
					$transaction1->status = 'successful';
					$transaction1->description = "انتقال وجه به " . $des_wallet->user->name;
					$transaction1->create_date = $date;
					$transaction1->save();

					$unique = uniqid('', false);
					$transaction2 = new Transaction();
					$transaction2->unique_id = $unique;
					$transaction2->user_id = $des_wallet->user->unique_id;
					$transaction2->wallet_id = $des_wallet->unique_id;
					$transaction2->price = $price;
					$transaction2->code = $unique;
					$transaction2->status = 'successful';
					$transaction2->description = "دریافت وجه از " . $user->name;
					$transaction2->create_date = $date;
					$transaction2->save();

					$transfer = new Transfer();
					$transfer->unique_id = uniqid('', false);
					$transfer->origin_id = $transaction1->wallet_id;
					$transfer->destination_id = $transaction2->wallet_id;
					$transfer->origin_user_id = $transaction1->user_id;
					$transfer->destination_user_id = $transaction2->user_id;
					$transfer->price = $price;
					$transfer->code = uniqid('', false);
					if ($transaction1 && $transaction2)
						$transfer->status = 'successful';
					$transfer->create_date = $date;
					$transfer->save();

					$log = "P:" . $transfer->price . " F:" . $transfer->origin_user_id . " T:" . $transfer->destination_user_id . " D:" . $transfer->create_date;
					CustomLog::info($log, "transaction");

					return response()->json([
						'error' => false,
						'code' => $transaction1->code
					], 201);
				} else
					return response()->json([
						'error' => true,
						'error_msg' => 'موجودی کافی نیست'
					], 201);
			}
		} else {
			return response()->json([
				'error' => true,
				'error_msg' => 'مشکلی به وجود آمده است'
			], 201);
		}
	}

	public function chargeWalletTemp(Request $request)
	{
		$user_id = $request->get('uid');
		$price = $request->get('price');

		$user = User::where("unique_id", $user_id)->first();
		$wallet = Wallet::where("unique_id", $user->wallet->unique_id)->first();

		$date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());

		$transaction = new Transaction();
		$transaction->unique_id = uniqid('', false);
		$transaction->user_id = $user_id;
		$transaction->wallet_id = $wallet->unique_id;
		$transaction->price = $price;
		$transaction->code = uniqid('', false);
		$transaction->description = 'شارژ کیف پول';
		$transaction->create_date = $date;
		$transaction->save();

		if ($transaction)
			return response()->json([
				'error' => false,
				'code' => $transaction->unique_id
			], 201);
		else
			return response()->json([
				'error' => true,
				'error_msg' => 'مشکلی به وجود آمده است'
			], 201);
	}

	public function pay($id)
	{
		$transaction = Transaction::where("unique_id", $id)->first();
		if ($transaction) {
			$client = new Client([
				'headers' => ['Content-Type' => 'application/json']
			]);
			$url = "https://pay.ir/payment/send";
			$params = [
				'api' => $this->API,
				'amount' => $transaction->price * 10,
				'redirect' => "http://hyper-online.ir/wallet_callback",
				'mobile' => $transaction->user->phone,
				'factorNumber' => $id,
			];
			$response = $client->post(
				$url,
				['body' => json_encode($params)]
			);

			$response = (array)json_decode($response->getBody()->getContents());

			if ($response['status'] == 1) {
				$transId = $response['transId'];
				return Redirect::to("http://pay.ir/payment/gateway/" . $transId);
			} else {
				return response()->json([
					'error' => true,
					'error_msg' => $response['errorCode']
				], 201);
			}
		} else
			return response()->json([
				'error' => true,
				'error_msg' => 'مشکلی به وجود آمده است'
			], 201);
	}

	public function callBack(Request $request)
	{
		$pay = new Pay();
		if (app('request')->exists('status')) $pay->status = $request->input('status');
		if (app('request')->exists('transId')) $pay->transId = $request->input('transId');
		if (app('request')->exists('factorNumber')) $pay->factorNumber = $request->input('factorNumber');
		if (app('request')->exists('cardNumber')) $pay->cardNumber = $request->input('cardNumber');
		if (app('request')->exists('message')) $pay->message = $request->input('message');
		$pay->save();

		$res = $this->verify($this->API, $pay->transId);
		$res = (array)json_decode($res);

		if ($res['status'] == 1) {
			header("location: hyper://charge?error=0&code=" . $pay->factorNumber);
		} else {
			header("location: hyper://charge?error=1&er_code=" . $res['errorCode']);
		}
		exit();
	}

	private function verify($api, $transId)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://pay.ir/payment/verify');
		curl_setopt($ch, CURLOPT_POSTFIELDS, "api=$api&transId=$transId");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$res = curl_exec($ch);
		curl_close($ch);
		return $res;
	}

	public function chargeWallet(Request $request)
	{
		$id = $request->get('uid');

		$transaction = Transaction::where("unique_id", $id)->first();

		$wallet = Wallet::where("unique_id", $transaction->wallet_id)->first();
		$wallet->price = (int)$wallet->price + (int)$transaction->price;
		$wallet->save();

		$date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());

		$transaction->update_date = $date;
		$transaction->status = 'successful';
		$transaction->save();

		if ($transaction)
			return response()->json([
				'error' => false
			], 201);
		else
			return response()->json([
				'error' => true,
				'error_msg' => 'مشکلی به وجود آمده است'
			], 201);
	}

	public function generateWallets()
	{
		$users = User::get();
		$date = $this->getDate($this->getCurrentTime()) . ' ' . $this->getTime($this->getCurrentTime());
		$count = count($users);
		$finalCount = 0;
		$code = 150;
		foreach ($users as $user) {
			$wallet = new Wallet();
			$wallet->unique_id = uniqid('', false);
			$wallet->user_id = $user->unique_id;
			$wallet->code = "HO-" . strval($code);
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
			if (File::exists($file))
				$finalCount++;
			$code++;
		}
		return response()->json([
			'count' => $count,
			'finalCount' => $finalCount
		], 201);
	}

	public function getTransactions(Request $request)
	{
		$id = $request->get('uid');

		$transactions = Transaction::where("user_id", $id)->orderBy('created_at', 'desc')->get();

		return response()->json([
			'error' => false,
			'list' => $transactions
		], 201);
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