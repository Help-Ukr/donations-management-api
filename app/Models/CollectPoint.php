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
 *     required={"id", "enabled", "name", "phone", "location", "updated_at", "created_at", "needed_items"},
 *     @OA\Property(property="id", type="number", title="Id", example="1"),
 *     @OA\Property(property="enabled", type="boolean", title="Is enabled current collect point", example="true"),
 *     @OA\Property(property="name", type="string", title="Collect point name", example="Space Meduza"),
 *     @OA\Property(property="description", type="text", title="Collect point description", example="Volunteers uniting to bring aid, donations & transport to Refugees and people in need. Sends convoys to the border regularly"),
 *     @OA\Property(property="phone", type="string", title="Collect point contact phone number", example="+491767890123"),
 *     @OA\Property(property="telegram", type="string", title="Collect point telegram account", example="@jax21ukr"),
 *     @OA\Property(property="instagram", type="string", title="Collect point instagram account", example="@insta"),
 *     @OA\Property(property="image", type="string", title="Collect point logo image", example="https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_92x30dp.png"),
 *     @OA\Property(property="location", type="object", required={"address", "latitude", "longitude"},
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
 *         @OA\Items( type="object", required={"item_category_id", "item_category_name", "item_category_icon"},
 *             @OA\Property(
 *                 property="item_category_id",
 *                 type="integer",
 *                 example="2"
 *             ),
 *             @OA\Property(
 *                 property="item_category_name",
 *                 type="string",
 *                 example="University"
 *             ),
 *             @OA\Property(
 *                 property="item_category_icon",
 *                 type="string",
 *                 example="🔦"
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

    protected $fillable = ['name', 'description', 'phone', 'telegram', 'instagram', 'image', 'address', 'latitude', 'longitude', 'user_id', 'enabled'];
    protected $appends = ['location'];
    protected $hidden = ['latitude', 'longitude', 'address', 'user_id'];
    protected $casts = ['enabled' => 'boolean', 'latitude' => 'float', 'longitude' => 'float'];

    public static function boot()
    {
        parent::boot();
        self::deleting(function($collectPoint){
            $collectPoint->neededItems->each->delete();
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
}
