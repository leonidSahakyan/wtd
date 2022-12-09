<?php
namespace App\Filters\Image;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class ProductList implements FilterInterface
{
    public function applyFilter(Image $image)
    {
    	return $image->fit(328, 400, function ($constraint) {
            $constraint->aspectRatio();
		    $constraint->upsize();
		});
    }
}