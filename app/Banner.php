<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Banner
 *
 * @property string $unique_id
 * @property string $image
 * @property string $title
 * @property string|null $link
 * @property int $type
 * @property int|null $size
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Banner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Banner whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Banner whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Banner whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Banner whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Banner whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Banner whereUniqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Banner whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Banner extends Model
{
    protected $primaryKey = 'unique_id';
    public $incrementing = false;
}
