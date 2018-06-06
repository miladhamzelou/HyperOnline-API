<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presenter extends Model
{
	protected $primaryKey = 'unique_id';
	public $incrementing = false;

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function presenter()
	{
		return $this->belongsTo(User::class, 'presenter_id');
	}
}
