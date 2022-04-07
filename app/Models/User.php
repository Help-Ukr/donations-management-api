<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ResetPasswordLinkNotification;

/**
 * @property int $id
 * @property string $name
 * @property string $password Password hash
 * @property string $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @OA\Schema(
 *     schema="User",
 *     @OA\Property(property="id", type="number", title="Id", example="1"),
 *     @OA\Property(property="name", type="string", title="Username", example="James Joseph Brown"),
 *     @OA\Property(property="email", type="email", title="User email", example="james.j.b@gmail.com"),
 *     @OA\Property(property="updated_at", type="datetime", example="2022-03-09T10:01:17.000000Z"),
 *     @OA\Property(property="created_at", type="datetime", example="2022-03-09T10:01:17.000000Z"),
 * )
 * @method static User create($attributes = [])
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordLinkNotification($token));
    }
}
