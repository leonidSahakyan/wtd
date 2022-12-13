<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
	use HasFactory;
    protected $table = 'product';

    public function getProductWithImage($id,$color=false){
    	$query = DB::table('product')->select('product.*','images.filename','images.ext','images.color')->where('product.id',$id);
        if($color){
            $query->where('images.color',$color);
        }
        $query->leftJoin('galleries','galleries.id','=','product.gallery_id');
        $query->leftJoin('images','images.parent_id','=','galleries.id');
        $item = $query->orderBy('images.ordering','asc')->first();
        if(!$item){
            $query = DB::table('product')->select('product.*','images.filename','images.ext','images.color')->where('product.id',$id);
            $query->leftJoin('galleries','galleries.id','=','product.gallery_id');
            $query->leftJoin('images','images.parent_id','=','galleries.id');
            $item = $query->orderBy('images.ordering','asc')->first();    
        }
        return $item;
    }
}
