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

	protected $hidden = ['salt', 'district', 'country' . 'location_x', 'location_y', 'remember_token', 'minPrice', 'maxPrice', 'update_date', 'updated_at'];

	public function comments()
	{
		return $this->hasMany(comment::class, 'user_id');
	}

	public function orders()
	{
		return $this->hasMany(Order::class, 'user_id');
	}

	public function wallet()
	{
		return $this->hasOne(Wallet::class, 'user_id');
	}

	public function company()
	{
		return $this->belongsTo(Company::class);
	}

	public function transactions()
	{
		return $this->hasMany(Transaction::class, 'user_id');
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
