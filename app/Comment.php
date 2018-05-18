<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Comment
 *
 * @property string $unique_id
 * @property string $user_id
 * @property string $user_name
 * @property string|null $user_image
 * @property string $body
 * @property string|null $answer
 * @property int $confirmed
 * @property int $seen
 * @property string $create_date
 * @property string|null $update_date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $type
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereCreateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereSeen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereUniqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereUpdateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereUserImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereUserName($value)
 * @mixin \Eloquent
 */
class Comment extends Model
{
    protected $primaryKey = 'unique_id';
    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
