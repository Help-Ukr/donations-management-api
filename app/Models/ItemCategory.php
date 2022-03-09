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
 *     @OA\Property(property="name", type="sring", title="Username", example="food"),
 *     @OA\Property(property="updated_at", type="datetime", example="2022-03-09T10:01:17.000000Z"),
 *     @OA\Property(property="created_at", type="datetime", example="2022-03-09T10:01:17.000000Z"),
 * )
 * @method static User create($attributes = [])
 */
class ItemCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
}
