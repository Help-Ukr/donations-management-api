<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NeededItem extends Model
{
    use HasFactory;

    protected $fillable = ['item_category_id'];
}
