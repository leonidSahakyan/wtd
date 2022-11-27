<?php
namespace App\Filters\Image;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class Services implements FilterInterface
{
    public function applyFilter(Image $image)
    {
    	return $image->fit(370, 313, function ($constraint) {
            $constraint->aspectRatio();
		    $constraint->upsize();
		});
    }
}