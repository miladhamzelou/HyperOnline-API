<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $primaryKey = 'unique_id';
    public $incrementing = false;
}
