<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
	protected $primaryKey = 'unique_id';
	public $incrementing = false;

	public function users()
	{
		return $this->hasMany(User::class);
	}
}
