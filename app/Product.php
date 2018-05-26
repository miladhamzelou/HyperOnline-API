<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Product
 *
 * @property string $unique_id
 * @property string $seller_id
 * @property string $category_id
 * @property string $name
 * @property string|null $image
 * @property float $point
 * @property int $point_count
 * @property string|null $description
 * @property int $off
 * @property int $count
 * @property int $confirmed
 * @property int $price
 * @property int $price_original
 * @property int $type
 * @property string|null $other
 * @property string $create_date
 * @property string|null $update_date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $sell
 * @property int $special
 * @property-read \App\Seller $seller
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereCreateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereOff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product wherePoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product wherePointCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product wherePriceOriginal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereSell($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereSpecial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereUniqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereUpdateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
	protected $primaryKey = 'unique_id';
	public $incrementing = false;

	protected $hidden = ['update_date', 'updated_at', 'point', 'point_count', 'sell'];

	public function seller()
	{
		return $this->belongsTo(Seller::class);
	}
}
