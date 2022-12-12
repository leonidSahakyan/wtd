<?php
namespace App\Filters\Image;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class ProductThumb implements FilterInterface
{
    public function applyFilter(Image $image)
    {
    	return $image->fit(270, 330, function ($constraint) {
            $constraint->aspectRatio();
		    $constraint->upsize();
		});
    }
}