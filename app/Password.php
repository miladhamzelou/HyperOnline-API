<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Password
 *
 * @property string $unique_id
 * @property string $user_id
 * @property string $name
 * @property string $phone
 * @property string|null $email
 * @property string $password
 * @property string $create_date
 * @property string|null $update_date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Password whereCreateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Password whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Password whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Password whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Password wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Password wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Password whereUniqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Password whereUpdateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Password whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Password whereUserId($value)
 * @mixin \Eloquent
 */
class Password extends Model
{
	protected $primaryKey = 'unique_id';
	public $incrementing = false;

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
