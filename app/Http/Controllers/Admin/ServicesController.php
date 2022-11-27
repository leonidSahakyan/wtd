<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Service;
use App\Models\Admin\ServiceTypes;
use App\Models\Admin\ServiceReplacement;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\ImageDB;


class ServicesController extends Controller
{
    public function services(Request $request){
        $page = (isset($_GET['page'])) ? $_GET['page'] : false;
        view()->share('page', $page);
        view()->share('menu', 'services');
        return view('admin.services.services_index');
    }
    

    public function servicesData(Request $request){
        $model = new Service();
        $filter = array('search' => $request->input('search'),
                        'status' => $request->input('filter_status'),
                        'featured'=> $request->input('featured',false));

        $items = $model->getAll(
        $request->input('start'),
        $request->input('length'),
        $filter,
        $request->input('sort_field'),
        $request->input('sort_dir'),
        );

        $data = json_encode(array('data' => $items['data'], 'recordsFiltered' => $items['count'], 'recordsTotal'=> $items['count']));
        return $data;
    }

    public function getServices(Request $request){
        $id = (int)$request['id'];
        if($id){
            $item = Service::find($id);
            if ($item->image_id) {
                $imageDb = new ImageDB();
                $item->image = $imageDb->get($item->image_id);
            }
            $mode = 'edit';
        }else{
            $item = new Service();
            $item->created_at = date("Y-m-d H:i:s");
            $mode= "add";
        }
        $data = json_encode(
            array('data' =>
                (String) view('admin.services.services_item', array(
                    'item'=>$item,
                    'mode' => $mode,
                )),
                'status' => 1)
            );

        return $data;
    }
    
    public function saveServices(Request $request){
    
        $validator  = Validator::make($request->all(), [
            'title'         => 'required',
            'image'         => 'required',
            'residential_price'         => 'required',
            'commercial_price'         => 'required',
            'description'   => 'required',
            'body'          => 'required',
            'for_business'          => 'nullable',
            'for_homeowner'          => 'nullable',
        ]);
        
        $for_business = $request->input('for_business') == "on" ? 1 : 0;
        $for_homeowner = $request->input('for_homeowner') == "on" ? 1 : 0;

        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->getMessageBag()->first()
            ]);
        }
        
        if($for_business == 0 && $for_homeowner == 0){
            return response()->json([
                'status'  => 0,
                'message' => "Pls select service type"
            ]);    
        }
        $validated = $validator->validated();
        
        $data = $request->all();
        $id = $request->input('id');
        if (!$id) {
            $item = new Service();
            $max = DB::table('services')->max('ordering');
            $item->ordering = (is_null($max) ? 1 : $max + 1);
        } else {
            $item = Service::find($id);
            if (!$item) return json_encode(array('status' => 0, 'message' => "Can't save"));
        }
      
        $item->image_id = $data['image'];
        if ($item->image_id) {
            $imageDB = ImageDB::find($item->image_id);
            $imageDB->save();
        }

        $item->published   = $data['published'];
        $item->title       = $data['title'];
        $item->for_business       = $for_business;
        $item->for_homeowner       = $for_homeowner;
        $item->residential_price = $data['residential_price'];
        $item->commercial_price = $data['commercial_price'];
        $item->body        = $data['body'];
        $item->description = $data['description'];
        $item->featured    = isset($data['featured']) ? 1 : 0;
        $item->save();
        $id = $item->id;

        if (isset($publishedNotification)) {
            return json_encode(array('status' => 1, 'message' => "Cant publish Without image", 'published' => 0));
        } else {
            return json_encode(array('status' => 1));
        }
    
    }

    public function removeServices(Request $request){
     
        $ids = $request->input('ids');
        foreach ($ids as $id) {
            $item = Service::find($id);
            if ($item) {
                if ($item->image_id) {
                    $image = ImageDB::find($item->image_id);
                    if ($item->image_id) {
                        $image->remove($item->image_id);
                    }
                }
                $item->delete();
            } else {
                return json_encode(array('status' => 0, 'message' => "Can't save"));
            }
        }
        $data = json_encode(array('status' => 1));
        return $data;
    }

    public function reorderingServices(Request $request){
        $ids = $request->input('ids');
        $newOrdering = count($ids);

        foreach($ids as $value => $key)
        {
            $item = Service::find(str_replace("row_", "", $key));
            if($item){
                $item->ordering = $newOrdering;
                $item->save();
                $newOrdering--;
            }
        }
        // DB::table('settings')->where('key', 'sync_time')->update(['value' => date("Y-m-d H:i:s")]);
        exit();
    }

    /////Types
    public function servicesTypeData(Request $request){
        $model = new ServiceTypes();
        $parent_id = $request->input('parent_id');
        $filter = array('search' => $request->input('search'),
                        'status' => $request->input('filter_status'),
                        'featured'=> $request->input('featured',false));

        $items = $model->getAll(
            $request->input('start'),
            $request->input('length'),
            $filter,
            $request->input('sort_field'),
            $request->input('sort_dir'),
            $parent_id
        );

        $data = json_encode(array('data' => $items['data'], 'recordsFiltered' => $items['count'], 'recordsTotal'=> $items['count']));
        return $data;
    }

    public function getServicesType(Request $request){
        $id = (int)$request['id'];
        if($id){
            $item = ServiceTypes::find($id);
            $mode = 'edit';
        }else{
            $item = new ServiceTypes();
            $parent_id = (int)$request['parent_id'];
            if(!$parent_id){
                return json_encode(array('status' => 0, 'message' => "Parent Id requierd"));
            }
            $item->created_at = date("Y-m-d H:i:s");
            $item->parent_id = $parent_id;
            $mode= "add";
        }
        $data = json_encode(
            array('data' =>
                (String) view('admin.services.services_type_item', array(
                    'item'=>$item,
                    'mode' => $mode,
                )),
                'status' => 1)
            );

        return $data;
    }

    public function saveServicesType(Request $request){
    
        $validator  = Validator::make($request->all(), [
            'title'         => 'required',
            'parent_id'         => 'required|int',
        ]);
      
        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->getMessageBag()->first()
            ]);
        }
        
        $data = $request->all();
        $id = $request->input('id');
        if (!$id) {
            $parent_id = $request->input('parent_id');
            $item = new ServiceTypes();
            $max = DB::table('services_types')->where('parent_id',$parent_id)->max('ordering');
            $item->ordering = (is_null($max) ? 1 : $max + 1);
        } else {
            $item = ServiceTypes::find($id);
            if (!$item) return json_encode(array('status' => 0, 'message' => "Can't save"));
        }
      


        $item->published   = $data['published'];
        $item->title       = $data['title'];
        $item->parent_id       = $data['parent_id'];
        $item->save();
        $id = $item->id;

        return json_encode(array('status' => 1));
    }

    public function removeServicesType(Request $request){
     
        $ids = $request->input('ids');
        foreach ($ids as $id) {
            $item = ServiceTypes::find($id);
            if ($item) {
                DB::table('services_types')->where('id', $id)->update(['deleted_at' => date("Y-m-d H:i:s")]);
                // $item->delete();
            } else {
                return json_encode(array('status' => 0, 'message' => "Can't save"));
            }
        }
        $data = json_encode(array('status' => 1));
        return $data;
    }
    
    ///////////// 
    public function servicesReplacementData(Request $request){
        $model = new ServiceReplacement();
        $parent_id = $request->input('parent_id');
        $filter = array('search' => $request->input('search'),
                        'status' => $request->input('filter_status'),
                        'featured'=> $request->input('featured',false));

        $items = $model->getAll(
            $request->input('start'),
            $request->input('length'),
            $filter,
            $request->input('sort_field'),
            $request->input('sort_dir'),
            $parent_id
        );

        $data = json_encode(array('data' => $items['data'], 'recordsFiltered' => $items['count'], 'recordsTotal'=> $items['count']));
        return $data;
    }

    public function getServicesReplacement(Request $request){
        $id = (int)$request['id'];
        if($id){
            $item = ServiceReplacement::find($id);
            $mode = 'edit';
        }else{
            $item = new ServiceReplacement();
            $parent_id = (int)$request['parent_id'];
            if(!$parent_id){
                return json_encode(array('status' => 0, 'message' => "Parent Id requierd"));
            }
            $item->created_at = date("Y-m-d H:i:s");
            $item->parent_id = $parent_id;
            $mode= "add";
        }
        $data = json_encode(
            array('data' =>
                (String) view('admin.services.services_replacement_item', array(
                    'item'=>$item,
                    'mode' => $mode,
                )),
                'status' => 1)
            );

        return $data;
    }

    public function saveServicesReplacement(Request $request){
    
        $validator  = Validator::make($request->all(), [
            'title'         => 'required',
            'parent_id'     => 'required|int',
            'price'         => 'int|nullable',
        ]);
      
        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->getMessageBag()->first()
            ]);
        }
        
        $data = $request->all();
        $id = $request->input('id');
        if (!$id) {
            $parent_id = $request->input('parent_id');
            $item = new ServiceReplacement();
            $max = DB::table('services_replacement')->where('parent_id',$parent_id)->max('ordering');
            $item->ordering = (is_null($max) ? 1 : $max + 1);
        } else {
            $item = ServiceReplacement::find($id);
            if (!$item) return json_encode(array('status' => 0, 'message' => "Can't save"));
        }
      


        $item->published   = $data['published'];
        $item->title       = $data['title'];
        $item->price       = $data['price'];
        $item->parent_id   = $data['parent_id'];
        $item->save();
        $id = $item->id;

        return json_encode(array('status' => 1));
    }

    public function removeServicesReplacement(Request $request){
     
        $ids = $request->input('ids');
        foreach ($ids as $id) {
            $item = ServiceReplacement::find($id);
            if ($item) {
                DB::table('services_replacement')->where('id', $id)->update(['deleted_at' => date("Y-m-d H:i:s")]);
            } else {
                return json_encode(array('status' => 0, 'message' => "Can't save"));
            }
        }
        $data = json_encode(array('status' => 1));
        return $data;
    }
}
