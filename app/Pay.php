<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Pay
 *
 * @property int $id
 * @property int|null $status
 * @property int|null $transId
 * @property string|null $factorNumber
 * @property string|null $cardNumber
 * @property string|null $message
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pay whereCardNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pay whereFactorNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pay whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pay whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pay whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pay whereTransId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Pay whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Pay extends Model
{
    //
}
