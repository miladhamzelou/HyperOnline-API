<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Seller
 *
 * @property string $unique_id
 * @property string $author_id
 * @property string $name
 * @property string|null $image
 * @property float $point
 * @property int $point_count
 * @property string $address
 * @property int $open_hour
 * @property int $close_hour
 * @property int $off
 * @property int $type
 * @property int $closed
 * @property int $confirmed
 * @property string $phone
 * @property string $state
 * @property string $city
 * @property string|null $description
 * @property int $send_price
 * @property int $min_price
 * @property string|null $location_x
 * @property string|null $location_y
 * @property string $create_date
 * @property string|null $update_date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Author $author
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Product[] $products
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereCloseHour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereClosed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereCreateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereLocationX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereLocationY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereMinPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereOff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereOpenHour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller wherePoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller wherePointCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereSendPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereUniqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereUpdateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Seller whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Seller extends Model
{
    protected $primaryKey = 'unique_id';
    public $incrementing = false;

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
