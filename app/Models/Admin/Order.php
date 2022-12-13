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
										'orders.first_name',
										'orders.last_name',
										'orders.total',
										'orders.status',
										'orders.created_at',
										'countries.title as country',
										)
								);
		$query->leftJoin('countries', 'countries.id', '=', 'orders.country_id');

		if($length != '-1'){
			$query->skip($start)->take($length);
		}

		$search = (isset($filter['search']) && strlen($filter['search']) > 0) ? $filter['search'] : false;

		if($search){
			$search = $filter['search'];
			$query->where(function($query) use ($search){
                            $query->where('sku', 'LIKE', '%'.$search.'%')
                                  ->orWhere('first_name', 'LIKE', '%'.$search.'%')
                                  ->orWhere('last_name', 'LIKE', '%'.$search.'%')
                                  ->orWhere('phone', 'LIKE', '%'.$search.'%')
                                  ->orWhere('address', 'LIKE', '%'.$search.'%')
                                  ->orWhere('email', 'LIKE', '%'.$search.'%');
                        });
		}else{
			if(isset($filter['status'])){
				$query->where('orders.status',$filter['status']);    
			}
			
			if(isset($filter['start_date']) && isset($filter['end_date'])){
				$query->where('orders.created_at','>',$filter['start_date'].' '.'00:00:00')->where('orders.created_at','<',$filter['end_date'].' '.'23:59:59');
			}
		}
		
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