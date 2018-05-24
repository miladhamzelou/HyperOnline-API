<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	protected $primaryKey = 'unique_id';
	public $incrementing = false;
	protected $fillable = [
		'name', 'phone', 'password', 'unique_id', 'code', 'address', 'state', 'city', 'create_date',
		'encrypted_password', 'salt'
	];

	public function comments()
	{
		return $this->hasMany(comment::class);
	}

	public function orders()
	{
		return $this->hasMany(Order::class);
	}

	public function wallets()
	{
		return $this->hasMany(Wallet::class);
	}

	public function company()
	{
		return $this->belongsTo(Company::class);
	}

	public function transactions()
	{
		return $this->hasMany(Transaction::class);
	}

	public function Role()
	{
		return $this->role;
	}

	public function isAdmin()
	{
		if ($this->role == "admin")
			return 1;
		else
			return 0;
	}

	public function getID()
	{
		return $this->unique_id;
	}
}
