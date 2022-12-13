<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Product extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product';

    
    public $timestamps  = false;
    
    public function getAll($start,$length,$filter,$sort_field,$sort_dir){

    	$query = DB::table($this->table);

		$query->select(array(DB::raw('SQL_CALC_FOUND_ROWS id'), 'id as DT_RowId', 'id', 'sku', 'price','title', 'ordering','status'));
		
		if($length != '-1'){
			$query->skip($start)->take($length);
		}

		if(isset($filter['status'])){
			$query->where('status',$filter['status']);    
		}

		if(isset($filter['parent_id'])){
			$query->where('parent_id',$filter['parent_id']);    
		}

		if( isset($filter['search']) && strlen($filter['search']) > 0 ){
			$query->where('title', 'LIKE', '%'. $filter['search'] .'%')->orWhere('sku', 'LIKE', '%'. $filter['search'] .'%');
		}

		$query->whereNull('deleted_at');
		$query->whereNull('temp');

		$query->orderBy($sort_field, $sort_dir);
		$data = $query->get();
		$count  = DB::select( DB::raw("SELECT FOUND_ROWS() AS recordsTotal;"))[0];

		$return['data'] = $data;
		$return['count'] = $count->recordsTotal;
		return $return;
    }
}
