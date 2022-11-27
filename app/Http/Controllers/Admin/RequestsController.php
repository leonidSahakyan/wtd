<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Requests;

class RequestsController extends Controller
{
    public function index(){
        view()->share('menu', 'requests');
        return view('admin.requests.index');
    }
    
    
    public function getRequests(Request $request){
        $id = (int)$request['id'];
        if(!$id) return 'error';
        
        $item =  DB::table('requests')->select('requests.id','requests.status as price')->where('requests.id', $id)->first();
        
        $data = json_encode(
            array('data' => 
                (String) view('admin.requests.item', array('item'=>$item)),'status' => 1)
            );
        return $data; 
    }

    public function data(Request $request){
        $model = new Requests();

        $filter = array(
            'status' => $request->input('filter_status'),
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
}