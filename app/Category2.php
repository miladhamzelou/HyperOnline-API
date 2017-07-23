<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category2 extends Model
{
    protected $primaryKey = 'unique_id';
    public $incrementing = false;

    public function category3s()
    {
        return $this->hasMany(Category3::class);
    }

    public function category1()
    {
        return $this->belongsTo(Category1::class);
    }
}
