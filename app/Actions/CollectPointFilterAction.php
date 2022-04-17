<?php

namespace App\Actions;

use App\Models\CollectPoint;
use Illuminate\Database\Eloquent\Collection;

class CollectPointFilterAction 
{
    public function handle($request): Collection
    {
        $query = CollectPoint::with(['neededItems'])->where('enabled', 1);
        
        if(array_key_exists('bbox', $request)){
            $coords = explode(',', $request['bbox']);
            $query->whereBetween('latitude', [$coords[2], $coords[0]])
                ->whereBetween('longitude', [$coords[1], $coords[3]]);
        }

        return $query->get();
    }
}