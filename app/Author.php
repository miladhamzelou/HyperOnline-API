<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $primaryKey = 'unique_id';
    public $incrementing = false;

    public function sellers()
    {
        return $this->hasMany(Seller::class);
    }
}
