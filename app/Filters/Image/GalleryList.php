<?php
namespace App\Filters\Image;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class GalleryList implements FilterInterface
{
    public function applyFilter(Image $image)
    {
    	return $image->fit(1000, 600, function ($constraint) {
            $constraint->aspectRatio();
		    $constraint->upsize();
		});
    }
}