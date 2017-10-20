<?php

namespace App\Jobs;

use App\Support;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $support;

    public function __construct(Support $support)
    {
        $this->support = $support;
    }

    public function handle()
    {
        Mail::to("hatamiarash7@gmail.com")
            ->send(new \App\Mail\Support($this->support));
    }
}
