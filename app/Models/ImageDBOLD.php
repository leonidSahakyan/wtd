<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use File;

class ImageDB extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'images';

    public $timestamps = false;
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

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
            // if($gallery_id){
            //     $data['parent_id'] = $gallery_id;

            //     $max = DB::table('images')->where('parent_id', $gallery_id)->max('ordering');
            //     $data['ordering'] = (is_null($max) ? 0 : $max + 1);
            // }
        //   if($temp){
        //       $tempStoreUntil = time() + (3 * 24 * 60 * 60);
        //       $data['temp'] = $tempStoreUntil;
        //   }
           $data['size'] = $size; 
           $data['filename'] = $filename; 
           $data['ext'] = $ext;  
        //    $data['created_at'] = \Carbon\Carbon::now()->toDateTimeString();  
        //    $data['updated_at'] = \Carbon\Carbon::now()->toDateTimeString();

        //    $id = DB::table('images')->insertGetId($data);
            return true;
        //    return $this->get($id);
        }
        return false;
    }

    /// NEW ///
    /// Upload avatar
    public function addAvatar($image,$userId){
        $filename = $hash = $this->generateFilename();
        $ext = $image->getClientOriginalExtension();
        $size = $image->getSize();

        if($image->move('users_avatar/', $filename.'.'.$ext)){
            $data = array();
            $data['size'] = $size; 
            $data['filename'] = $filename; 
            $data['ext'] = $ext;  

            $oldImage = DB::table('users')->select('avatar')->where('id', $userId)->first();
            if($oldImage){
                $path = 'users_avatar/'.$oldImage->avatar;
                File::delete($path);
            }
            DB::table('users')->where('id', $userId)->update(['avatar' => $filename.'.'.$ext]);
            return asset('images/avatar/'.$filename.'.'.$ext);
        }
        return false;
    }
    public function addServiceImage($image,$serviceId){

        $filename = $hash = $this->generateFilename();
        $ext = $image->getClientOriginalExtension();
  
        // switch ($image->mime) {
        //     case 'image/png':
        //         $ext = 'png';
        //         break;
        //     case 'image/jpg':
        //         $ext = 'jpg';
        //         break;
        //     case 'image/jpeg':
        //         $ext = 'jpeg';
        //         break;
        //     default:
        //         $ext = 'jpeg';
        //         break;
        // }
        // $fullFileName = $filename.'.'.$ext;
        if($image->move('content/', $filename.'.'.$ext)){
        // if($image->save('content/'.$fullFileName,100)){
            $id = DB::table('images')->insertGetId([
              'parent_id' => $serviceId,
              'filename' => $filename.'.'.$ext
            ]);
            return array('id'=>$id,"thumb_url"=>asset('images/galleryList/'.$filename.'.'.$ext),"image_url"=>asset('images/original/'.$filename.'.'.$ext));
        }
        return false;
    }
    public function addVerifyImageNew($userId,$image,$type){
        $filename = $hash = $this->generateFilename();
        $ext = $image->getClientOriginalExtension();
        $size = $image->getSize();
    
        if($image->move('verification/', $filename.'.'.$ext)){
            $data = array();
            $data['size'] = $size; 
            $data['filename'] = $filename; 
            $data['ext'] = $ext;  
    
            $oldImage = DB::table('verification')->select($type.' as img')->where('user_id', $userId)->first();
            if($oldImage){
                $path = 'verification/'.$oldImage->img;
                File::delete($path);
            }
    
    
            DB::table('verification')->where('user_id', $userId)->update([$type => $filename.'.'.$ext]);
            return asset('images/document/'.$filename.'.'.$ext);
        }
        return false;
    }
    /// NEW ///
    public function addBase64Image($image,$userId){

        $filename = $this->generateFilename();

        switch ($image->mime) {
            case 'image/png':
                $ext = 'png';
                break;
            case 'image/jpg':
                $ext = 'jpg';
                break;
            case 'image/jpeg':
                $ext = 'jpeg';
                break;
            default:
                $ext = 'jpeg';
                break;
        }

        if($image->save('users_avatar/'.$filename.'.'.$ext,100)){
          
            $oldImage = DB::table('users')->select('avatar')->where('id', $userId)->first();
            if($oldImage){
                $path = 'users_avatar/'.$oldImage->avatar;
                File::delete($path);
            }
            DB::table('users')->where('id', $userId)->update(['avatar' => $filename.'.'.$ext]);
            return asset('images/avatar/'.$filename.'.'.$ext);
        }
        return false;
    }

    public function addVerifyImage($userId,$image,$type){
        $filename = $this->generateFilename();

        switch ($image->mime) {
            case 'image/png':
                $ext = 'png';
                break;
            case 'image/jpg':
                $ext = 'jpg';
                break;
            case 'image/jpeg':
                $ext = 'jpeg';
                break;
            default:
                $ext = 'jpeg';
                break;
        }

        if($image->save('verification/'.$filename.'.'.$ext,100)){
            $oldImage = DB::table('verification')->select($type.' as img')->where('user_id', $userId)->first();
            if($oldImage){
                $path = 'verification/'.$oldImage->img;
                File::delete($path);
            }
            DB::table('verification')->where('user_id', $userId)->update([$type => $filename.'.'.$ext]);
            return asset('images/document/'.$filename.'.'.$ext);
        }
        return false;
    }

    public function removeVerifyImage($userId,$type){
        $img = DB::table('verification')->select($type.' as img')->where('user_id', $userId)->first();
        if($img){
            $path = 'verification/'.$img->img;
            File::delete($path);
        }
        DB::table('verification')->where('user_id', $userId)->update([$type => NULL]);
    }

    public function removeAvatar($userId){
        $img = DB::table('users')->select('avatar')->where('id', $userId)->first();
        if($img){
            $path = 'users_avatar/'.$img->avatar;
            File::delete($path);
        }
        DB::table('users')->where('id', $userId)->update(['avatar' => NULL]);
    }
    public function addImage($image,$serviceId){

      $filename = $this->generateFilename();

      switch ($image->mime) {
          case 'image/png':
              $ext = 'png';
              break;
          case 'image/jpg':
              $ext = 'jpg';
              break;
          case 'image/jpeg':
              $ext = 'jpeg';
              break;
          default:
              $ext = 'jpeg';
              break;
      }
      $fullFileName = $filename.'.'.$ext;
      if($image->save('content/'.$fullFileName,100)){
          $id = DB::table('images')->insertGetId([
            'parent_id' => $serviceId,
            'filename' => $filename.'.'.$ext
          ]);
          return array('id'=>$id,"thumb_url"=>asset('images/galleryList/'.$fullFileName),"image_url"=>asset('images/original/'.$fullFileName));
      }
      return false;
  }

    public function addOriginal($image,$filename){
      
      if($image->move('img/', $filename)){
        return true;
      }
      return false;
  }


    public function remove($imageId){
      $image = ImageDB::find($imageId);
      if($image){
        $path = 'users_avatar/'.$image->filename.'.'.$image->ext;
        File::delete($path);

        $image->delete();
	     } 
    }

    public function generateFilename(){
		return substr(md5(microtime()),0,12);
	}
}