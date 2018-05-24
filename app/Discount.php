<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Discount
 *
 * @property string $unique_id
 * @property string $code
 * @property string $percent
 * @property string $min_price
 * @property string|null $expire
 * @property string $status
 * @property string|null $rules
 * @property int $max_use
 * @property int $usage
 * @property string $create_date
 * @property string $update_date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discount whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discount whereCreateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discount whereExpire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discount whereMaxUse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discount whereMinPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discount wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discount whereRules($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discount whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discount whereUniqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discount whereUpdateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discount whereUsage($value)
 * @mixin \Eloquent
 */
class Discount extends Model
{
	protected $primaryKey = 'unique_id';
	public $incrementing = false;
}
