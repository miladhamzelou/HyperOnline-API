<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Device
 *
 * @property string $unique_id
 * @property string|null $name
 * @property string|null $os_name
 * @property string|null $os_version
 * @property string|null $version_release
 * @property string|null $device
 * @property string|null $model
 * @property string|null $product
 * @property string|null $brand
 * @property string|null $display
 * @property string|null $abi
 * @property string|null $abi2
 * @property string|null $unknown
 * @property string|null $hardware
 * @property string|null $id2
 * @property string|null $manufacturer
 * @property string|null $serial
 * @property string|null $user
 * @property string|null $host
 * @property string|null $location_x
 * @property string|null $location_y
 * @property string $create_date
 * @property string|null $update_date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Device whereAbi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Device whereAbi2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Device whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Device whereCreateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Device whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Device whereDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Device whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Device whereHardware($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Device whereHost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Device whereId2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Device whereLocationX($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Device whereLocationY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Device whereManufacturer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Device whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Device whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Device whereOsName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Device whereOsVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Device whereProduct($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Device whereSerial($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Device whereUniqueId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Device whereUnknown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Device whereUpdateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Device whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Device whereUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Device whereVersionRelease($value)
 * @mixin \Eloquent
 */
class Device extends Model
{
    protected $primaryKey = 'unique_id';
    public $incrementing = false;
}
