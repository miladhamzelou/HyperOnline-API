<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $primaryKey = 'unique_id';
    public $incrementing = false;

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
