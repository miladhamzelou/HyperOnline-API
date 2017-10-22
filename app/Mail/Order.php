<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Order extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function build()
    {
        return $this->view('emails.order')
            ->with([
                "body" => $this->email['body'],
                "order" => $this->email['order']
            ])
            ->attach(public_path('/ftp/factors/' . $this->email['order']['code'] . '.pdf'));
    }
}