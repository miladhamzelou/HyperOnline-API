<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Order extends Mailable
{
    use Queueable, SerializesModels;

    protected $support;

    public function __construct(\App\Support $support)
    {
        $this->support = $support;
    }

    public function build()
    {
        return $this->view('emails.order')
            ->with([
                "body" => $this->support->body
            ]);
    }
}