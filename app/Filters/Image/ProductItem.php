<?php
namespace App\Filters\Image;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class ProductItem implements FilterInterface
{
    public function applyFilter(Image $image)
    {
    	return $image->fit(670, 820, function ($constraint) {
            $constraint->aspectRatio();
		    $constraint->upsize();
		});
    }
}