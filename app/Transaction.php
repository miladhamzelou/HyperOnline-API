<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	protected $primaryKey = 'unique_id';
	public $incrementing = false;
}
