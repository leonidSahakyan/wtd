<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Settings;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';

    protected $fillable = [
     'email', 'master_id', 'last_name', 'first_name', 'total', 'address', 'user_id','status','comment','rate','created_at','updated_at'
    ];

    public function getAll($start,$length,$filter,$sort_field,$sort_dir){
    	$query = DB::table('orders');

		$query->select(array(DB::raw('SQL_CALC_FOUND_ROWS orders.id'), 
										'orders.id as DT_RowId',
										'orders.total',
										'orders.status',
										'orders.created_at',
										)
								);
		
		if($length != '-1'){
			$query->skip($start)->take($length);
		}
		
		if(isset($filter['status'])){
			$query->where('orders.status',$filter['status']);    
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

	    public function forMiniday(){
        $miniday   = Settings::where('key','miniday')->first()->value;
        $miniorder = Settings::where('key','miniorder')->first()->value;
        $data = date("Y-m-d");
        $allData  = Order::Where('order_date',$data)->get();
        $lengt =$allData->count();
        $count = $miniday;
        if($lengt > $miniday){
            $count = $miniday +1;
        }
        return $count;

    }
}

