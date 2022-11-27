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

    	$query = DB::table('services');

		$query->select(array(DB::raw('SQL_CALC_FOUND_ROWS services.id'), 
										'services.id as DT_RowId', 
										'services.title as title',  
										'services.ordering as ordering',  
										'services.published as published'));
		
			if($length != '-1'){
				$query->skip($start)->take($length);
			}
			if( isset($filter['search']) && strlen($filter['search']) > 0 ){
				$query->where('services.title', 'LIKE', '%'. $filter['search'] .'%')->orWhere('services.price', 'LIKE', '%'. $filter['search'] .'%');
			}
			$query->orderBy($sort_field, $sort_dir);
			$data = $query->get();
			$count  = DB::select( DB::raw("SELECT FOUND_ROWS() AS recordsTotal;"))[0];
			$return['data'] = $data;
			$return['count'] = $count->recordsTotal;
			return $return;
    }
}
