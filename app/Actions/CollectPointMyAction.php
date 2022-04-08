<?php

namespace App\Actions;

use App\Models\CollectPoint;

class CollectPointMyAction 
{
    public function handle(): CollectPoint
    {
        return CollectPoint::where('user_id', \Auth::user()->id)->with(['neededItems'])->firstOrFail();
    }
}