<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Support extends Mailable
{
    use Queueable, SerializesModels;

    protected $support;

    public function __construct(\App\Support $support)
    {
        $this->support = $support;
    }

    public function build()
    {
        if ($this->support->log == 0)
            return $this->view('emails.support')
                ->with([
                    "title" => $this->support->section,
                    "body" => $this->support->body
                ]);
        else
            return $this->view('emails.support')
                ->with([
                    "title" => $this->support->section,
                    "body" => $this->support->body
                ])
                ->attach(storage_path('logs/laravel.log'));
    }
}