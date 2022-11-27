<?php 

namespace App\Helpers;
use DB;
class ImageHelper
{

	public function __construct()
    {

    }

	public function generateFilename(){
		return substr(md5(microtime()),0,12);
	}

	public static function getImage($id,$size="original"){

		$image = DB::table('images')
		        ->select('*')
		        ->where('id', $id)
		        ->first();
		
		if($image){
			$image->path = asset('images/'.$size.'/'.$image->filename.'.'.$image->ext);
			$image->params = unserialize($image->params);
		}
		return $image;
	}
}