<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;
use File;

class Doc extends Model
{
      /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'images';
    public $timestamps = false;

    public function get($id){
      $image = DB::table('images')
                ->select('*')
                ->where('id', $id)
                ->first();
      if($image){
        $image->path = asset('images/backendSmall/'.$image->filename.'.'.$image->ext);
        $image->path_original = asset('images/original/'.$image->filename.'.'.$image->ext);
        $image->path_small = asset('images/selfSmall/'.$image->filename.'.'.$image->ext);
        $image->path_medium = asset('images/selfMedium/'.$image->filename.'.'.$image->ext);
        $image->path_large = asset('images/selfLarge/'.$image->filename.'.'.$image->ext);
      }
      return $image;
    }

    public function add($image,$gallery_id = false,$temp = 0){

        $filename = $hash = $this->generateFilename();
        $ext = $image->getClientOriginalExtension();
        $size = $image->getSize();

        if($image->move('content/', $filename.'.'.$ext)){
           $data = array();
            if($gallery_id){
                $data['parent_id'] = $gallery_id;

                $max = DB::table('images')->where('parent_id', $gallery_id)->max('ordering');
                $data['ordering'] = (is_null($max) ? 0 : $max + 1);
            }
          if($temp){
              $tempStoreUntil = time() + (3 * 24 * 60 * 60);
              $data['temp'] = $tempStoreUntil;
          }
          
           $data['size'] = $size;
           $data['filename'] = $filename;
           $data['ext'] = $ext;
           $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();
            $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();

           $id = DB::table('images')->insertGetId($data);

           return $this->get($id);
        }
        return false;
    }

//     public function addOriginal($image,$filename){

//       if($image->move('img/', $filename)){
//         return true;
//       }
//       return false;
//   }

    // public function remove($imageId){
    //   $image = Doc::find($imageId);
    //     if($image){
    //         $path = 'content/'.$image->filename.'.'.$image->ext;
    //         File::delete($path);

    //         $image->delete();
    //     }
    // }
    public function generateFilename(){
		return substr(md5(microtime()),0,12);
	}
    public function addBase64Image($image): bool|string {


        $filename = $this->generateFilename();
        switch ($image->mime) {
            case 'image/png':
                $ext = 'png';
                break;
            case 'image/jpg':
                $ext = 'jpg';
                break;
            default:
                $ext = 'jpeg';
                break;
        }
        $filePath=$filename.'.'.$ext;
       if($image->save('signature/'.$filename.'.'.$ext,100)){
           $data=['filename' => $filename . '.' . $ext];
           DB::table('images')->insert($data);
           return $filePath;
        }
        return false;
    }

    public function remove($imageId){
        $image = Doc::find($imageId);
        if($image){
            $path = 'content/'.$image->filename.'.'.$image->ext;
            File::delete($path);

            $image->delete();
        } 
    }
}
