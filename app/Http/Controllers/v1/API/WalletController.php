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

class WalletController extends Controller
{
	public function getWalletByUser($id)
	{
		$user = User::where('unique_id', $id)->first();
		if ($user)
			return response()->json([
				'error' => false,
				'wallet' => $user->wallets
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
}