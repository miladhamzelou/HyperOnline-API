<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use phplusir\smsir\Smsir;

class SendSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $sms;

    public function __construct($sms)
    {
        $this->sms = $sms;
    }

    public function handle()
    {
        Smsir::send($this->sms['msg'], $this->sms['phone']);
    }
}
