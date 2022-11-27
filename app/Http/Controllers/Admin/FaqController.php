<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Faq;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\ImageDB;


class FaqController extends Controller
{
    public function faq(Request $request){
        $page = (isset($_GET['page'])) ? $_GET['page'] : false;
        view()->share('page', $page);
        view()->share('menu', 'faq');
        return view('admin.faq.faq_index');
    }


    public function faqData(Request $request){
        $model = new Faq();
        $filter = array('search' => $request->input('search'),
            'status' => $request->input('filter_status'),
            //'featured'=> $request->input('featured',false)
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

    public function getFaq(Request $request){
        $id = (int)$request['id'];
        if($id){
            $item = Faq::find($id);

            $mode = 'edit';
        }else{
            $item = new Faq();
            $item->created_at = date("Y-m-d H:i:s");
            $mode= "add";
        }
        $data = json_encode(
            array('data' =>
                (String) view('admin.faq.faq_item', array(
                    'item'=>$item,
                    'mode' => $mode,
                )),
                'status' => 1)
        );

        return $data;
    }

    public function saveFaq(Request $request){

        $validator  = Validator::make($request->all(), [
            'question' => 'string',
            'answer'   => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 0,
                'message' => $validator->getMessageBag()->first()
            ]);
        }
        $validated = $validator->validated();

        $data = $request->all();
        //dd($data);
        $id = $request->input('id');
        if (!$id) {
            $item = new Faq();
            $max = DB::table('faq')->max('ordering');
            $item->ordering = (is_null($max) ? 1 : $max + 1);
        } else {
            $item = Faq::find($id);
            if (!$item) return json_encode(array('status' => 0, 'message' => "Can't save"));
        }
        $item->published   = $data['published'];
        $item->question    = $data['question'];
        $item->answer      = $data['answer'];
        $item->save();
        $id = $item->id;

        if (isset($publishedNotification)) {
            return json_encode(array('status' => 1, 'message' => "Cant publish Without image", 'published' => 0));
        } else {
            return json_encode(array('status' => 1));
        }

    }

    public function removeFaq(Request $request){

        $ids = $request->input('ids');
        foreach ($ids as $id) {
            $item = Faq::find($id);
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

    public function reorderingFaq(Request $request){
        $ids = $request->input('ids');
        $newOrdering = count($ids);

        foreach($ids as $value => $key)
        {
            $item = Faq::find(str_replace("row_", "", $key));
            if($item){
                $item->ordering = $newOrdering;
                $item->save();
                $newOrdering--;
            }
        }
        // DB::table('settings')->where('key', 'sync_time')->update(['value' => date("Y-m-d H:i:s")]);
        exit() ;
    }
}

