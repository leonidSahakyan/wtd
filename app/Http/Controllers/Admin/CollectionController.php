<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Collection;
use App\Models\Admin\ImageDB;
use App\Models\Admin\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CollectionController extends Controller
{
    public function collections(){
        $collection = Collection::select('id','title')->orderBy('id', 'desc')->get();
        view()->share('collection', $collection);
        view()->share('menu', 'collection');
        return view('admin.collection.index');
    }

    public function collectionsData(Request $request){
        $model = new Collection();

        $filter = array('search' => $request->input('search'),
                        'status' => $request->input('filter_status'));

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

    public function getCollection(Request $request){

        $id = (int)$request['id'];
        if($id){
            $item = Collection::find($id);
            $mode = "Edit";
        }else{
            $item = new Collection();
            $item->created_at = date("Y-m-d H:i:s");
            $max = DB::table('collections')->max('ordering');
            $item->ordering = (is_null($max) ? 1 : $max + 1);
            $item->temp = 1;
            $mode= "add";
            $item->save();
        }

        if($item->image_id){
            $imageDb = new ImageDB();
            $item->image = $imageDb->get($item->image_id);
        }
        
        $data = json_encode(
            array('data' =>
                (String) view('admin.collection.item', array(
                    'item'=>$item,
                    'mode' => $mode
                )),
                'status' => 1)
            );

        return $data;
    }

    public function saveCollection(Request $request){
        $id = (int)$request['id'];

        $validator = \Validator::make($request->all(), [
            'id' => 'required|int',
            'status' => 'required|in:0,1',
            'title' => 'required|string|min:2|max:100',
            'title_droped' => 'required|string|min:2|max:100',
            'slug' => 'required|string|min:2|max:100',
        ]);

        if ($validator->fails())return response()->json(['status'=>0,'errors'=>$validator->errors()->all()]);

        $slug = strtolower(str_replace(' ', '-', $request->slug));
        $checkSlug = Collection::where('slug', $slug)->where('id','!=',$id)->whereNull('deleted_at')->first();
        if($checkSlug)return json_encode(array('status' => 0, 'errors' => ["Slug already exist"]));

        $item = Collection::find($id);
        if(!$item) return json_encode(array('status' => 0, 'errors' => ["Can't save"]));
        
        $item->image_id = (int)$request->cover;
        if($item->image_id){
            $image = ImageDB::find($item->image_id);
            if($image){
                if($image->temp != null){
                    $image->temp = null;
                    $image->save();
                }
            }else{
                $item->image_id = null;
            }
        }

        $item->temp = null;
        $item->featured  = $request->featured;
        $item->status = $request->status;
        $item->title = $request->title;
        $item->title_droped = $request->title_droped;
        $item->slug = $request->slug;
        $item->save();

        return json_encode(array('status' => 1, 'message' => 'Successfully saved!'));
    }

    public function removeCollection(Request $request){
        $ids = $request['ids'];
        foreach ($ids as $id) {
            $categoryHasChild = Product::select('id')->where('parent_id',$id)->whereNull('deleted_at')->first();
            if($categoryHasChild){
                return json_encode(array('status' => 0, 'message' => "Please first remove collection item(s)"));  
            }
            $item = Collection::find($id);
            $item->status = 0;
            $item->save();
            if(!$item->delete()){
                return json_encode(array('status' => 0, 'message' => "Can't remove"));
            }
        }

        $data = json_encode(array('status' => 1));
        return $data;
    }

    public function reorderingCollection(Request $request){
        $ids = $request->input('ids');
        $newOrdering = count($ids);

        foreach($ids as $value => $key)
        {
            $item = Collection::find(str_replace("row_", "", $key));
            if($item){
                $item->ordering = $newOrdering;
                $item->save();
                $newOrdering--;
            }
        }
        exit();
    }
    public function unAttachImage(Request $request){
        $itemId = (int)$request->id;   
        if($itemId){
            $item = Collection::find($itemId);    
            $item->image_id = null;
            $item->save();
        }
    }
}
