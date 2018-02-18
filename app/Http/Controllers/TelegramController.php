<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
	public function info()
	{
		$response = Telegram::getMe();
		return $response;
	}

	public function info_webhook()
	{
		$response = Telegram::getWebhookInfo();
		return $response;
	}

	public function set()
	{
		$result = Telegram::setWebhook([
			'url' => 'https://hyper-online.ir/' . config('telegram.bot_token') . '/webhook',
			'certificate' => '/var/www/HyperOnline-API/ssl/bundle.cer'
		]);
		return $result;
	}

	public function webhook(Request $request)
	{
		$update = Telegram::commandsHandler(true);
		Log::info($update);
		Log::info($request);
		return 'ok';
	}
}
