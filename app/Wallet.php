<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
	protected $primaryKey = 'unique_id';
	public $incrementing = false;

	protected $hidden = ['user', 'updated_at'];

	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function transactions()
	{
		return $this->hasMany(Transaction::class, 'wallet_id');
	}
}
