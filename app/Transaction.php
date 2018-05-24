<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	protected $primaryKey = 'unique_id';
	public $incrementing = false;

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function wallet()
	{
		return $this->belongsTo(Wallet::class);
	}

	public function company()
	{
		return $this->belongsTo(Company::class);
	}
}
