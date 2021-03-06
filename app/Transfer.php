<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
	protected $primaryKey = 'unique_id';
	public $incrementing = false;

	protected $hidden = ['update_date', 'updated_at'];
}
