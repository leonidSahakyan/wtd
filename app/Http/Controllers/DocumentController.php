<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Doc;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Validator;

class DocumentController extends Controller
{   
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function galleryData(){
        $model = new Gallery();
        
        $gallery_id = (int)$this->request->input('gallery_id');
        if($gallery_id){
            $gallery = $model->get($gallery_id);
            if($gallery){
                $data = json_encode(array('data' => $gallery, 'status' => 1));   
            }else{
                $data = json_encode(array('message' => "Can't get gallery", 'status' => 0));
            }
        }else{
            $model->temp = 1;
            $model->save();
            $insertedId = $model->id;
            $data = json_encode(array('new_gallery_id' => $insertedId, 'status' => 2));   
        }
        
        return $data;
    }

    public function upload(){

        $image = $this->request->file('file');
        $gallery_id = (int)$this->request->input('gallery_id');
        $temp = (int)$this->request->input('temp');
        // $original = (int)$this->request->input('original');
        // $filename = $this->request->input('filename');


        $thumb = $this->request->input('thumb') ? $this->request->input('thumb') : 'path';
        
        $fileArray = array('image' => $image);

        $rules = array(
          'image' => 'mimes:jpeg,jpg,JPG,png|required|max:200000' // max 10000kb
        );

        $validator = Validator::make($fileArray, $rules);
        if ($validator->fails())
        {   
            $messages = $validator->errors();
            
            $responseMessages = '';
            foreach ($messages->all(':message') as $message) {
                $responseMessages .= $message;
            }
            return response()->json(['status' => 0, 'message'=> $responseMessages]);
        }else{
            $model = new Doc();
            // if($original){
            //     $image = $model->addOriginal($image,$filename);
            //     return response()->json(['status' => 1, 'imageId'=> null, 'path' => url('/img/'.$filename) ]);
            // }else{
                $image = $model->add($image,$gallery_id,$temp);
                return response()->json(['status' => 1, 'imageId'=> $image->id, 'path' => $image->$thumb ]);
            // }
        }
    }
    public function remove(){
        $image_id = (int)$this->request->input('imageId');
        $model = new Doc();
        $model->remove($image_id);
        return true;
    }

}
