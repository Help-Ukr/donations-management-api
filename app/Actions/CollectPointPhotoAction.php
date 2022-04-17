<?php

namespace App\Actions;

use App\Models\CollectPoint;
use \Mechawrench\PhpSkynet\PhpSkynet;

class CollectPointPhotoAction 
{
    public function handle(string $filePath): string
    {
        $answer = PhpSkynet::upload($filePath);
        $photoUrl = config('php-skynet.uploded_file_host') . $answer['skylink'];
        
        CollectPoint::where('user_id', \Auth::user()->id)->update(['image' => $photoUrl]);
        
        return $photoUrl;
    }
}