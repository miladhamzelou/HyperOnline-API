<?php
/**
 * Created by PhpStorm.
 * User: hatamiarash7
 * Date: 2018-05-25
 * Time: 20:32
 */

namespace App\Http\Controllers\v1\API;


use App\Http\Controllers\Controller;
use App\User;
use App\Wallet;
use Illuminate\Support\Facades\File;
use SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;

include(app_path() . '/Common/jdf.php');

class WalletController extends Controller
{
	public function getWalletByUser($id)
	{
		$user = User::where('unique_id', $id)->first();
		if ($user)
			return response()->json([
				'error' => false,
				'wallet' => $user->wallet
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
				'wallet' => $wallet
			], 201);
		else
			return response()->json([
				'error' => true,
				'error_msg' => "مشکلی پیش آمده است"
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