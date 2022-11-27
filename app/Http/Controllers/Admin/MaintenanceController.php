<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Maintenance;

class MaintenanceController extends Controller
{
    public function index(){
        view()->share('menu', 'maintenance');
        return view('admin.maintenance.index');
    }


    public function getMaintenance(Request $request){
        $id = (int)$request['id'];
        if(!$id) return 'error';

        $item =  DB::table('maintenance')->select('maintenance.id','maintenance.price')->where('maintenance.id', $id)->first();

        $data = json_encode(
            array('data' =>
                (String) view('admin.maintenance.item', array('item'=>$item)),'status' => 1)
        );
        return $data;
    }

    public function data(Request $request){
        $model = new Maintenance();

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
