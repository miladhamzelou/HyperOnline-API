<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Category1
 *
 * @property string $unique_id
 * @property string $parent_id
 * @property string $name
 * @property string|null $image
 * @property float $point
 * @property int $point_count
 * @property int $off
 * @property int|null $type_name
 * @property string $create_date
 * @property string|null $update_date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Category2[] $category2s
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category1 whereCreateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category1 whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category1 whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category1 whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category1 whereOff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category1 whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category1 wherePoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category1 wherePointCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category1 whereTypeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category1 whereUniqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category1 whereUpdateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category1 whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category1 extends Model
{
	protected $primaryKey = 'unique_id';
	public $incrementing = false;

	public function category2s()
	{
		return $this->hasMany(Category2::class, 'parent_id');
	}
}
