<?php

namespace App\Http\Controllers\Admin;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Users;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
class UserController extends Controller
{
    public function usersIndex(){
        $page = (isset($_GET['page'])) ? $_GET['page'] : false;

        view()->share('page', $page);
        view()->share('menu', 'users');
        return view('admin.users.users');
    }

    public function userData(Request $request){
        $model = new Users();

        $filter = array('search' => $request->input('search'),
                        'status' => $request->input('filter_status'),
                        'verify' => $request->input('filter_verification'));    

        $items = $model->getAll(
            $request->input('start'),
            $request->input('length'),
            $filter,
            $request->input('sort_field'),
            $request->input('sort_dir')
        );

        $data = json_encode(
            array('data' => $items['data'],
            'recordsFiltered' => $items['count'],
            'recordsTotal'=> $items['count']));
        return $data;
    }
    public function userGet(Request $request){
      
        $id = (int)$request['id'];
        $page = (isset($request['page']) && $request['page'] == 'verification' ) ? true : false;
        // $item = $id ? Users::find($id) : new Users();   
       
        if($id){

            $item = Users::find($id);

            // if($item->avatar && $item->avatar != null){
            //     $item->avatar = asset('images/backendSmall/'.$item->avatar);
            // }
            $mode = "edit";

            // $services =  DB::table('services')->select('services.id','categories.title_en as category_title','services.price')
            //             ->leftJoin('categories', 'categories.id', '=', 'services.category_id')
            //             ->where('user_id', $id)->get();
            
            // $verification =  DB::table('verification')->select('*')->where('user_id', $id)->first();
            // if($services){
            //     foreach($services as $service){
            //         $imagesArray = [];
            //         $images =  DB::table('images')->select('id','filename')->where('parent_id', $service->id)->get();
            //         if($images){
            //             foreach($images as $image){
            //                 $imagesArray[] = array('id'=>$image->id,'thumb_url'=>asset('images/backendSmall/'.$image->filename),'image_url'=>asset('images/original/'.$image->filename));
            //             }
            //             $service->images = $imagesArray;
            //         }
            //     }
                
            // }
            // $item->services = $services;
        }else{
            return json_encode(array('status' => 0, 'message' => 'User is required.'));
            
            $item = new Users(); 
            $item->id = 0;
            $mode = "add";
        }

        $data = json_encode(
            array('data' => 
                (String) view('admin.users.item', array('item'=>$item,'mode' => $mode,  'page' => $page)),'status' => 1)
            );
        return $data; 
    }

    public function auserSave(Request $request){

        $validator  = Validator::make($request->all(), [
            'email'      => ['required',Rule::unique('users')->ignore($request->id)],
            'first_name' => 'required',
            'last_name'  => 'required'
        ]);
      
        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->getMessageBag()->first()
            ]);
        }
        $validated = $validator->validated();
        $id = (int)$request['id'];
        if(!$id){
            return json_encode(array('status' => 0, 'message' => 'User is required.'));
        }else{
            $item = Users::find($id);
        }
       
        $item->first_name = $request['first_name'];
        $item->last_name  = $request['last_name'];
        $item->email      = $request['email'];
       
       
        $item->save();
        return json_encode(array('status' => 1));
    }
    
    public function verify(Request $request){
        $validator = \Validator::make($request->all(), [
            'verify_id' => 'required|int',
            'status' => 'required|in:base,pending,declined,approved',
        ]);

        if ($validator->fails())
        {
            return response()->json(['message' => $validator->errors()], 401);
        }
        
        $id = (int)$request['verify_id'];
        
        $verification =  DB::table('verification')->select('*')->where('id', $id)->first();
        if(!$verification){
            return json_encode(array('status' => 0, 'message' => 'User not submit'));
        }
        
        
        $data = array();
        $data['status'] = $request['status'];
        $data['message'] = $request['message'];
        
        DB::table('verification')->where('id', $id)->update($data);
        
        if($verification->status != $request['status']){
            DB::table('users')->where('id', $verification->user_id)->update(['verify'=> $request['status']]);
            
            if(in_array($request['status'],['approved','declined'])){
                $notification = new Notification();
                $description = $request['status'] == 'approved' ? 'Verification is successfull.' : 'Verification is faild.';
                $notificationData = array('type' => 'user_verification');
                $notification->send($verification->user_id,"Verification of account",$description,"order_request_timeout",false,$notificationData);
            }

        }
        return json_encode(array('status' => 1));
    }
    // public function getServices(){
      
    //     $model = new Service();
    //     $user_id = (int)$this->request->input('user_id'); 

    //     $items = $model->getServices(
    //         $this->request->input('start'),
    //         $this->request->input('length'),
    //         $user_id,
    //         $this->request->input('sort_field'),
    //         $this->request->input('sort_dir')
    //     );

    //     $data = json_encode(array('data' => $items['data'], 'recordsFiltered' => $items['count']));
     
    //     return $data;
    // }

    // public function getService(Request $request){
      
    //     $id = (int)$request->input('id');

    //     if($id){
    //         $item = Service::find($id);
    //         $mode = 'edit';
    //     }else{
    //         $owner_id = (int)$request->input('owner_id');
    //         if(!$owner_id)return json_encode(array('status' => 0, 'message' => "Bad request"));
    
    //         $item = new Service();
    //         $item->id = 0;
    //         $item->owner_id = $owner_id;
    //         $mode = 'add';
    //     }

    //     $data = json_encode(
    //                     array('data' => 
    //                         (String) view('admin.users.ItemServices', array(
    //                             'item'=>$item,
    //                             'mode' => $mode
    //                         )),
    //                         'status' => 1)
    //                     );
    //     return $data;  
    // }


    // public function saveServices(Request $request){        

    //     $data = $request->all();
    //     $servicesId = (int)$request->input('servicesId');
    //     if(!$servicesId){
    //         $item = new Service();
    //     }else{
    //         $item = Service::find($servicesId);
    //         if(!$item) return json_encode(array('status' => 0, 'message' => "Can't save"));
    //     }
      
    //     $item->category_id  = $data['category_id'];
    //     $item->price        = $data['price'];
    //     $item->user_id      = $data['user_id'];
    //     $item->description  = $data['description'];
    //     $item->save();
    //     $id = $item->id;
    //     return json_encode(array('status' => 1));
    // }

}