<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Slider;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\ImageDB;


class SliderController extends Controller
{
    public function slider(Request $request){
        $page = (isset($_GET['page'])) ? $_GET['page'] : false;
        view()->share('page', $page);
        view()->share('menu', 'slider');
        return view('admin.slider.index');
    }


    public function sliderData(Request $request){
        $model = new Slider();
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

    public function getSlider(Request $request){
        $id = (int)$request['id'];
        if($id){
            $item = Slider::find($id);
            if ($item->image_id) {
                $imageDb = new ImageDB();
                $item->image = $imageDb->get($item->image_id);
            }
            $mode = 'edit';
        }else{
            $item = new Slider();
            $item->created_at = date("Y-m-d H:i:s");
            $mode= "add";
        }
        $data = json_encode(
            array('data' =>
                (String) view('admin.slider.item', array(
                    'item'=>$item,
                    'mode' => $mode,
                )),
                'status' => 1)
        );

        return $data;
    }

    public function saveSlider(Request $request){

        $validator  = Validator::make($request->all(), [
            'title'         => 'required',
            'image'         => 'required',
            'description'   => 'required',
            'link'          => 'nullable',
            'linktype'      => 'required',
            'namenutton'    => 'nullable'
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
            $item = new Slider();
            $max = DB::table('slider')->max('ordering');
            $item->ordering = (is_null($max) ? 1 : $max + 1);
        } else {
            $item = Slider::find($id);
            if (!$item) return json_encode(array('status' => 0, 'message' => "Can't save"));
        }

        $item->image_id = $data['image'];
        if ($item->image_id) {
            $imageDB = ImageDB::find($item->image_id);
            $imageDB->save();
        }

        $item->published   = $data['published'];
        $item->title       = $data['title'];
        $item->link        = $data['link'];
        $item->namebutton  = $data['namebutton'];
        $item->linktype    = $data['linktype'];
        $item->description = $data['description'];
        //$item->featured    = isset($data['featured']) ? 1 : 0;
        $item->save();
        $id = $item->id;

        if (isset($publishedNotification)) {
            return json_encode(array('status' => 1, 'message' => "Cant publish Without image", 'published' => 0));
        } else {
            return json_encode(array('status' => 1));
        }

    }

    public function removeSlider(Request $request){

        $ids = $request->input('ids');
        foreach ($ids as $id) {
            $item = Slider::find($id);
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

    public function reorderingSlider(Request $request){
        $ids = $request->input('ids');
        $newOrdering = count($ids);

        foreach($ids as $value => $key)
        {
            $item = Slider::find(str_replace("row_", "", $key));
            if($item){
                $item->ordering = $newOrdering;
                $item->save();
                $newOrdering--;
            }
        }
        // DB::table('settings')->where('key', 'sync_time')->update(['value' => date("Y-m-d H:i:s")]);
        exit();
    }
}
