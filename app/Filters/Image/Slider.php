<?php
namespace App\Filters\Image;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class Slider implements FilterInterface
{
    public function applyFilter(Image $image)
    {
    	return $image->fit(658, 796, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
    }
}