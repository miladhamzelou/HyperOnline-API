<?php

namespace App\Http\Controllers;

use app\Commands\StartCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;

class TelegramController extends Controller
{
    public function info(){
        $telegram = new Api(config('telegram.bot_token'));
        $response = $telegram->getMe();

        $response = $telegram->getUpdates();

        return $response;

    }

    public function webhook(Request $request){
        return 'OK';
    }
}
