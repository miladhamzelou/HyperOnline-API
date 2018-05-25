<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Option
 *
 * @property string $unique_id
 * @property int $category
 * @property int $category_count
 * @property int $off
 * @property int $off_count
 * @property int $new
 * @property int $new_count
 * @property int $popular
 * @property int $popular_count
 * @property int $most_sell
 * @property int $most_sell_count
 * @property int $collection
 * @property int $collection_count
 * @property int $banner
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $version
 * @property int $offline
 * @property string|null $offline_msg
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereBanner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereCategoryCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereCollection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereCollectionCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereMostSell($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereMostSellCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereNew($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereNewCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereOff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereOffCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereOffline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereOfflineMsg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option wherePopular($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option wherePopularCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereUniqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Option whereVersion($value)
 * @mixin \Eloquent
 */
class Option extends Model
{
	protected $primaryKey = 'unique_id';
	public $incrementing = false;
}
