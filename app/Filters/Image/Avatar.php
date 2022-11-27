<?php
namespace App\Filters\Image;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class Avatar implements FilterInterface
{
    public function applyFilter(Image $image)
    {
    	return $image->fit(300, 300, function ($constraint) {
		    $constraint->upsize();
		});
    }
}