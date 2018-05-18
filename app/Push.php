<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Push
 *
 * @property int $id
 * @property string $title
 * @property string $body
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Push whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Push whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Push whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Push whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Push whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Push extends Model
{
    //
}
