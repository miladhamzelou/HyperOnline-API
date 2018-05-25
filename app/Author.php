<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Author
 *
 * @property string $unique_id
 * @property string $name
 * @property string $phone
 * @property string $mobile
 * @property string $state
 * @property string $city
 * @property string|null $image
 * @property string $address
 * @property string $mCode
 * @property string $create_date
 * @property string|null $update_date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Seller[] $sellers
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereCreateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereMCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereUniqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereUpdateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Author extends Model
{
	protected $primaryKey = 'unique_id';
	public $incrementing = false;

	public function sellers()
	{
		return $this->hasMany(Seller::class, 'author_id');
	}
}
