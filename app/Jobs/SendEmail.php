<?php

namespace App\Jobs;

use App\Mail\Order;
use App\Mail\Support;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email, $type;

    public function __construct($email, $type = 0)
    {
        $this->email = $email;
        $this->type = $type;
    }

    public function handle()
    {
        if ($this->type == 0)
            $this->normalEmail($this->email);
        elseif ($this->type == 1)
            $this->orderEmail($this->email);
        elseif ($this->type == 2)
            $this->supportEmail($this->email);
    }

    private function orderEmail($data)
    {
        Mail::to($data['to'])
            ->cc("hatamiarash7@gmail.com")
            ->queue(new Order($data));
    }

    private function normalEmail($data)
    {
        Mail::to($data['to'])
            ->cc("hatamiarash7@gmail.com")
            ->queue(new Order($data));
    }

    private function supportEmail($data)
    {
        Mail::to($data['to'])
            ->cc("hatamiarash7@gmail.com")
            ->queue(new Support($data));
    }
}
