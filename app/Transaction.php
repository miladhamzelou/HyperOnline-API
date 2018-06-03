<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	protected $primaryKey = 'unique_id';
	public $incrementing = false;

	protected $hidden = ['update_date', 'updated_at'];

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function wallet()
	{
		return $this->belongsTo(Wallet::class . 'wallet_id');
	}

	public function company()
	{
		return $this->belongsTo(Company::class, 'company_id');
	}
}
