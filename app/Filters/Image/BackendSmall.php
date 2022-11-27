<?php
namespace App\Filters\Image;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class BackendSmall implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        return $image->fit(100, 100, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
    }
}