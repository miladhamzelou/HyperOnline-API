<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Order
 *
 * @property string $unique_id
 * @property string $seller_id
 * @property string $user_id
 * @property string $code
 * @property string $seller_name
 * @property string $user_name
 * @property string $user_phone
 * @property string $stuffs
 * @property string $stuffs_id
 * @property string $stuffs_count
 * @property int $price
 * @property int $price_send
 * @property int $price_original
 * @property int $hour
 * @property string $pay_method
 * @property string $status
 * @property string|null $description
 * @property string $create_date
 * @property string|null $update_date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $stuffs_desc
 * @property int $temp
 * @property string|null $transId
 * @property-read \App\Seller $seller
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCreateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereHour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order wherePayMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order wherePriceOriginal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order wherePriceSend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereSellerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereStuffs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereStuffsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereStuffsDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereStuffsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereTemp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereTransId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUniqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUpdateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUserPhone($value)
 * @mixin \Eloquent
 * @property string $pay_way
 * @property string|null $wallet_price
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order wherePayWay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereWalletPrice($value)
 */
class Order extends Model
{
    protected $primaryKey = 'unique_id';
    public $incrementing = false;

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
