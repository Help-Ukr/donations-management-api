<?php

namespace App\Actions;

use App\Models\CollectPoint;

class CollectPointMyAction 
{
    public function handle(): CollectPoint|null
    {
        return CollectPoint::where('user_id', \Auth::user()->id)->with(['neededItems'])->first();
    }
}