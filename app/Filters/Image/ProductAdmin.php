<?php
namespace App\Filters\Image;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class ProductAdmin implements FilterInterface
{
    public function applyFilter(Image $image)
    {
    	return $image->fit(160, 196, function ($constraint) {
            $constraint->aspectRatio();
		    $constraint->upsize();
		});
    }
}