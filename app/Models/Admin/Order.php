<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    protected $table = 'orders';

    public function getAll($start,$length,$filter,$sort_field,$sort_dir){
    	$query = DB::table('orders');

		$query->select(array(DB::raw('SQL_CALC_FOUND_ROWS orders.id'), 
										'orders.id as DT_RowId',
										'orders.sku',
										'orders.total',
										'orders.status',
										'orders.type',
										'orders.created_at',
										)
								);
		
		if($length != '-1'){
			$query->skip($start)->take($length);
		}

		if(Auth::guard('admin')->user()->role != 'superadmin'){
			$masterId = Auth::guard('admin')->user()->id;
			$query->where('orders.master_id',$masterId);
		}
		if(isset($filter['status'])){
			$query->where('orders.status',$filter['status']);    
		}
		
		if(isset($filter['type'])){
			$query->where('orders.type',$filter['type']);    
		}

		if(isset($filter['start_date']) && isset($filter['end_date'])){
			$query->where('orders.created_at','>',$filter['start_date'].' '.'00:00:00')->where('orders.created_at','<',$filter['end_date'].' '.'23:59:59');
		}
		// if(isset($filter['category']) &&  $filter['category'] != -1){
		// 	$query->where('categories.id',$filter['category']);    
		// }
		$query->orderBy($sort_field, $sort_dir);
		$data = $query->get();

		foreach ($data as $d) {
			$d->DT_RowId = "row_".$d->DT_RowId;
		}

		$count  = DB::select( DB::raw("SELECT FOUND_ROWS() AS recordsTotal;"))[0];

		$return['data'] = $data;
		$return['count'] = $count->recordsTotal;
    	return $return;
    }
}