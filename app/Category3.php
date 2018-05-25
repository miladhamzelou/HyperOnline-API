<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Category3
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
 * @property-read \App\Category2 $category2
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $products
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category3 whereCreateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category3 whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category3 whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category3 whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category3 whereOff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category3 whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category3 whereParentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category3 wherePoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category3 wherePointCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category3 whereUniqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category3 whereUpdateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category3 whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category3 extends Model
{
	protected $primaryKey = 'unique_id';
	public $incrementing = false;

	public function products()
	{
		return $this->hasMany(Product::class, 'category_id');
	}

	public function category2()
	{
		return $this->belongsTo(Category2::class);
	}
}
