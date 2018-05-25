<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Category2
 *
 * @property string $unique_id
 * @property string $parent_id
 * @property string $name
 * @property string $parent_name
 * @property string|null $image
 * @property float $point
 * @property int $point_count
 * @property int $off
 * @property string $create_date
 * @property string|null $update_date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Category1 $category1
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Category3[] $category3s
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category2 whereCreateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category2 whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category2 whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category2 whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category2 whereOff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category2 whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category2 whereParentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category2 wherePoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category2 wherePointCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category2 whereUniqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category2 whereUpdateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category2 whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category2 extends Model
{
	protected $primaryKey = 'unique_id';
	public $incrementing = false;

	public function category3s()
	{
		return $this->hasMany(Category3::class, 'parent_id');
	}

	public function category1()
	{
		return $this->belongsTo(Category1::class);
	}
}
