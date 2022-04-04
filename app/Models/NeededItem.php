<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NeededItem extends Model
{
    use HasFactory;

    protected $fillable = ['item_category_id'];
    protected $hidden = ['created_at', 'updated_at', 'id', 'collect_point_id', 'itemCategory'];
    protected $appends = ['item_category_name'];

    public function getItemCategoryNameAttribute()
    {
        return $this->itemCategory->name;
    }

    /**
     * @return HasOne
     */
    public function itemCategory()
    {
        return $this->hasOne(ItemCategory::class, 'id', 'item_category_id');
    }
}
