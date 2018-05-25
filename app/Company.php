<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Company
 *
 * @property string $unique_id
 * @property string $name
 * @property string|null $description
 * @property string $create_date
 * @property string $update_date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transaction[] $transactions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereCreateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereUniqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereUpdateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Company extends Model
{
	protected $primaryKey = 'unique_id';
	public $incrementing = false;

	public function users()
	{
		return $this->hasMany(User::class, 'company_id');
	}

	public function transactions()
	{
		return $this->hasMany(Transaction::class);
	}
}
