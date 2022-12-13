<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Product;
use App\Models\Admin\Collection;
use App\Models\Admin\Gallery;

class ProductController extends Controller
{
    public function index(){
        $collections = Collection::select('id','title')->where('status',1)->whereNull('deleted_at')->get();

        // $asd = config('constants.attributes.colors');

        view()->share('collections', $collections);
        view()->share('menu', 'products');
        return view('admin.product.index');
    }
    
    public function get(Request $request){
        $collections = Collection::select('id','title')->whereNull('deleted_at')->where('status',1)->get();
        
        $id = (int)$request['id'];
        $mode = $id ? "edit" : "add";
        if($id){
            $item = Product::findOrFail($id);
        }else{
            $item = new Product();
            $item->created_at = date("Y-m-d H:i:s");
            $max = DB::table('product')->max('ordering');
            $item->ordering = (is_null($max) ? 1 : $max + 1);
            $item->temp = 1;
            $item->save();
        }
        
        $hasGallery = true;
        if($item->gallery_id == null){
            $hasGallery = false;
            $model = new Gallery();
            $model->temp = null;
            $model->save();
            $item->gallery_id = $model->id;
            $item->save();
            // DB::table('product')->where('id', $item->id)->update(['gallery_id' => $item->gallery_id]);
        }
        
        $item->sizes = json_decode($item->sizes) ? json_decode($item->sizes) : []; 
        $item->colors = json_decode($item->colors) ? json_decode($item->colors) : [];

        $data = json_encode(
            array('data' => 
                (String) view('admin.product.item', array('item'=>$item,
                                                    'hasGallery'=>$hasGallery,
                                                    'logs'=>false,
                                                    'mode'=>$mode,
                                                    'collections'=>$collections,
                                                )),'status' => 1)
            );
        return $data; 
    }

    public function data(Request $request){
        $model = new Product();

        $filter = array(
            'search' => $request->input('search'),
            'status' => $request->input('filter_status'),
            'parent_id' => $request->input('filter_collection'),
        );

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

    public function save(Request $request){
        $id = (int)$request['id'];

        $validator = \Validator::make($request->all(), [
            'id' => 'required|int',
            'parent_id' => 'required|int',
            'price' => 'required|int',
            'status' => 'required|in:0,1',
            'title' => 'required|string|min:2|max:100',
            'description' => 'string|max:500',
            'slug' => 'required|string|min:2|max:100',
            'sku' => 'required|string|min:2|max:10'
        ]);

        if ($validator->fails())return response()->json(['status'=>0,'errors'=>$validator->errors()->first()]);

        $slug = strtolower(str_replace(' ', '-', $request->slug));
        $checkSlug = Product::where('slug', $slug)->where('id','!=',$id)->whereNull('deleted_at')->first();
        if($checkSlug)return json_encode(array('status' => 0, 'errors' => ["Slug already exist"]));

        $sku = strtolower(str_replace(' ', '-', $request->sku));
        $checkSku = Product::where('slug', $sku)->where('id','!=',$id)->whereNull('deleted_at')->first();
        if($checkSku)return json_encode(array('status' => 0, 'errors' => ["Sku already exist"]));

        $item = Product::find($id);
        if(!$item) return json_encode(array('status' => 0, 'errors' => ["Can't save"]));
        
        $colors = array();
        if(isset($request->colors)){
            foreach($request->colors as $color){
                $colors[] = $color;
            }
        }
        $item->colors = json_encode($colors);

        $sizes = array();
        if(isset($request->sizes)){
            foreach($request->sizes as $size){
                $sizes[] = $size;
            }
        }
        $item->sizes = json_encode($sizes);

        if($item->temp != null)$item->temp = null;
        $item->title = $request->title;
        $item->slug = $slug;
        $item->sku = $request->sku;
        $item->parent_id = $request->parent_id;
        $item->description = $request->description;
        $item->price = $request->price;
        $item->status = $request->status;
        $item->featured  = isset($request->featured) ? 1 : 0;
        $item->save();

        return json_encode(array('status' => 1, 'message' => 'Successfully saved!'));
    }

    public function sort(Request $request){
        $ids = $request->input('ids');
        $newOrdering = count($ids);

        foreach($ids as $value => $key)
        {
            $item = Product::find(str_replace("row_", "", $key));
            if($item){
                $item->ordering = $newOrdering;
                $item->save();
                $newOrdering--;
            }
        }
    }

    public function remove(Request $request){
        $ids = $request['ids'];
        foreach ($ids as $id) {
            $item = Product::find($id);
            $item->status = 0;
            $item->deleted_at = date("Y-m-d H:i:s");
            $item->save();
        }

        $data = json_encode(array('status' => 1));
        return $data;
    }
}