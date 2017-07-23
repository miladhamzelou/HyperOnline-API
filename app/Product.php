<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'unique_id';
    public $incrementing = false;

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
