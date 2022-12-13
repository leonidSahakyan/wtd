<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Meta;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use App\Models\Admin\ImageDB;


class MetaController extends Controller
{
    public function meta(Request $request){
        $page = (isset($_GET['page'])) ? $_GET['page'] : false;
        view()->share('page', $page);
        view()->share('menu', 'meta');
        return view('admin.meta.index');
    }

    public function metaData(Request $request){
        $model = new Meta();
        $filter = false;

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

    public function getMeta(Request $request){
        $id = (int)$request['id'];
        if($id){
            $item = Meta::find($id);
            if ($item->image_id) {
                $imageDb = new ImageDB();
                $item->image = $imageDb->get($item->image_id);
            }
            $mode = 'edit';
        }else{
            $item = new Meta();
            $item->created_at = date("Y-m-d H:i:s");
            $mode= "add";
        }
        $data = json_encode(
            array('data' =>
                (String) view('admin.meta.item', array(
                    'item'=>$item,
                    'mode' => $mode,
                )),
                'status' => 1)
        );

        return $data;
    }

    public function saveMeta(Request $request){

        $validator  = Validator::make($request->all(), [
            'title'         => 'string|nullable',
            'image'         => 'int|nullable',
            'description'   => 'string|nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->getMessageBag()->first()
            ]);
        }
        $validated = $validator->validated();

        $data = $request->all();

        $id = $request->input('id');
        if (!$id) {
            $item = new meta();

        } else {
            $item = meta::find($id);
            if (!$item) return json_encode(array('status' => 0, 'message' => "Can't save"));
        }

         $item->image_id = $data['image'];
        if ($item->image_id) {
            $imageDB = ImageDB::find($item->image_id);
            $imageDB->save();
        }

        if($item->pagename != 'home'){
            $item->published   = $data['published'];
        }

        $item->title       = $data['title'];
        $item->description = $data['description'];
        $item->save();
        $id = $item->id;
        return json_encode(array('status' => 1));
    }
}
