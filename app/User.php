<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $primaryKey = 'unique_id';
    public $incrementing = false;
    protected $fillable = [
        'name', 'phone', 'password', 'unique_id', 'code', 'address', 'state', 'city', 'create_date',
        'encrypted_password', 'salt'
    ];

    public function comments()
    {
        return $this->hasMany(comment::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function Role()
    {
        return $this->role;
    }
}
