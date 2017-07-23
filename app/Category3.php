<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category3 extends Model
{
    protected $primaryKey = 'unique_id';
    public $incrementing = false;

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function category2()
    {
        return $this->belongsTo(Category2::class);
    }
}
