<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $primaryKey = 'unique_id';
    public $incrementing = false;

    public function comments()
    {
        return $this->hasMany(comment::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
