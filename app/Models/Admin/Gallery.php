<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Gallery extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'galleries';

    public function get($id,$size="original"){
    	$query = DB::table('galleries');

		$query->select('id');
		$query->where('id', $id);

		$gallery = $query->first();

		if($gallery){
    		$images = DB::table('images')
                ->select('id','filename','ext','ordering','size','color')
			    ->where('parent_id', $gallery->id)
                ->orderBy('ordering', 'asc')
                ->get();

            foreach ($images as $key => $value) {
                $images[$key]->original = asset('images/original/'.$value->filename.'.'.$value->ext);
                $images[$key]->path = asset('images/'.$size.'/'.$value->filename.'.'.$value->ext);
                // $images[$key]->params = unserialize($value->params);
            }
			$gallery->images  = $images;
		}
    	return $gallery;
    }
}

