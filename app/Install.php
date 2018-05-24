<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Install
 *
 * @property string $unique_id
 * @property string|null $user_id
 * @property string $device_id
 * @property string $create_date
 * @property string $update_date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Install whereCreateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Install whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Install whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Install whereUniqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Install whereUpdateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Install whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Install whereUserId($value)
 * @mixin \Eloquent
 */
class Install extends Model
{
	protected $primaryKey = 'unique_id';
	public $incrementing = false;
}
