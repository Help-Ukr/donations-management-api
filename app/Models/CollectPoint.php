<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $telegram
 * @property string $image
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @OA\Schema(
 *     schema="CollectPoint",
 *     @OA\Property(property="id", type="number", title="Id", example="1"),
 *     @OA\Property(property="user_id", type="number", title="User id", example="1"),
 *     @OA\Property(property="name", type="sring", title="Collect point name", example="Space Meduza"),
 *     @OA\Property(property="phone", type="sring", title="Collect point contact phone number", example="+491767890123"),
 *     @OA\Property(property="telegram", type="sring", title="Collect point telegram account", example="@jax21ukr"),
 *     @OA\Property(property="image", type="sring", title="Collect point logo image", example="https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_92x30dp.png"),
 *     @OA\Property(property="location", type="object",
 *         @OA\Property(
 *            property="address",
 *            type="string",
 *            example="Skalitzer Straße 80, 10990 Berlin"
 *         ),
 *         @OA\Property(
 *            property="latitude",
 *            type="number",
 *              format="double",
 *            example="59.334591"
 *         ),
 *         @OA\Property(
 *            property="longitude",
 *            type="number",
 *            format="double",
 *            example="18.06324"
 *         ),
 *     ),
 *     @OA\Property(property="needed_items", type="array",
 *         @OA\Items( type="object",
 *             @OA\Property(
 *                 property="item_category_id",
 *                 type="integer",
 *                 example="2"
 *             ),
 *         ),
 *     ),
 *     @OA\Property(property="available_items", type="array",
 *         @OA\Items( type="object",
 *             @OA\Property(
 *                 property="item_category_id",
 *                 type="integer",
 *                 example="2"
 *             ),
 *             @OA\Property(
 *                 property="quantity",
 *                 type="integer",
 *                 example="10"
 *             ),
 *         ),
 *     ),
 *     @OA\Property(property="updated_at", type="datetime", example="2022-03-09T10:01:17.000000Z"),
 *     @OA\Property(property="created_at", type="datetime", example="2022-03-09T10:01:17.000000Z"),
 * )
 * @method static User create($attributes = [])
 */
class CollectPoint extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'telegram', 'image', 'address', 'latitude', 'longitude', 'user_id'];
    protected $appends = ['location'];
    protected $hidden = ['latitude', 'longitude', 'address'];

    public static function boot()
    {
        parent::boot();
        self::deleting(function($collectPoint){
            $collectPoint->neededItems->each->delete();
            $collectPoint->availableItems->each->delete();
        });
    }

    public function getLocationAttribute()
    {
        return [
            "address" => $this->address,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
        ];
    }

    /**
     * @return HasMany
     */
    public function neededItems()
    {
        return $this->hasMany(NeededItem::class);
    }

    /**
     * @return HasMany
     */
    public function availableItems()
    {
        return $this->hasMany(AvailableItems::class);
    }
}
