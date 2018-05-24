<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Changelog
 *
 * @property string $unique_id
 * @property int $version
 * @property string $changes
 * @property string $create_date
 * @property string $update_date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Changelog whereChanges($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Changelog whereCreateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Changelog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Changelog whereUniqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Changelog whereUpdateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Changelog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Changelog whereVersion($value)
 * @mixin \Eloquent
 */
class Changelog extends Model
{
	protected $primaryKey = 'unique_id';
	public $incrementing = false;
}
