<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $primaryKey = 'unique_id';
    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
