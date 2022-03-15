<?php

namespace App\Actions;

use App\Models\CollectPoint;
use Illuminate\Database\Eloquent\Collection;

class CollectPointMyAction 
{
    public function handle(): Collection
    {
        return CollectPoint::where('user_id', \Auth::user()->id)->with(['neededItems', 'availableItems'])->get();
    }
}