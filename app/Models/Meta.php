<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Meta extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'meta';

    public function getMeta($page){
		$meta = DB::table('meta')->select('title','description','image_id')->where('pagename', $page)->where('published',1)->first();
		if(!$meta){
			$meta = DB::table('meta')->select('title','description','image_id')->where('pagename', 'home')->first();
		}
		$meta->imagePath =  asset('asset/img/logo.png');
		if($meta->image_id){
			$image = DB::table('images')->select('*')->where('id', $meta->image_id)->first();
			if($image){
				$meta->imagePath = asset('images/metaThumb/'.$image->filename.'.'.$image->ext);
			}
		}
		$meta->locale = 'en_EN';
		$meta->type = 'website';
    	return $meta; 
    }
	public function getMetaProduct($id){
		$meta = DB::table('product')->select('title','description','image_id')->where('id', $id)->where('status',1)->whereNull('deleted_at')->first();

		$meta->imagePath =  asset('asset/img/logo.png');
		if($meta->image_id){
			$image = DB::table('images')->select('*')->where('id', $meta->image_id)->first();
			if($image){
				$meta->imagePath = asset('images/metaThumb/'.$image->filename.'.'.$image->ext);
			}
		}
    	$meta->locale = 'en_EN';
		$meta->type = 'website';
    	return $meta; 
	}
	public function getMetaCollection($id){
		$meta = DB::table('collections')->select('title','image_id')->where('id', $id)->where('status',1)->whereNull('deleted_at')->first();
		$metaHome = DB::table('meta')->select('description')->where('pagename', 'home')->first();

		$meta->description = $metaHome->description;
		$meta->imagePath =  asset('asset/img/logo.png');
		if($meta->image_id){
			$image = DB::table('images')->select('*')->where('id', $meta->image_id)->first();
			if($image){
				$meta->imagePath = asset('images/metaThumb/'.$image->filename.'.'.$image->ext);
			}
		}
    	$meta->locale = 'en_EN';
		$meta->type = 'website';
    	return $meta; 
	}
}