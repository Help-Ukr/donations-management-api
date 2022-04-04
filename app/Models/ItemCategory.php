<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @OA\Schema(
 *     schema="ItemCategory",
 *     @OA\Property(property="id", type="number", title="Id", example="1"),
 *     @OA\Property(property="item_category_id", type="number", title="Parent Id", example="1"),
 *     @OA\Property(property="name", type="sring", title="Username", example="food"),
 *     @OA\Property(property="icon", type="sring", title="icon", example="🔦"),
 * )
 * @method static User create($attributes = [])
 */
class ItemCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon'];
    protected $hidden = ['created_at', 'updated_at'];
}
