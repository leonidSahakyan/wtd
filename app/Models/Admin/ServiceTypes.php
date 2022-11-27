<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class ServiceTypes extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'services_types';

    
    public $timestamps  = false;
    
    public function getAll($start,$length,$filter,$sort_field,$sort_dir,$parent_id){

    	$query = DB::table('services_types');

		$query->select(array(DB::raw('SQL_CALC_FOUND_ROWS services_types.id'), 
										'services_types.id as DT_RowId', 
										'services_types.title as title',
										'services_types.parent_id as parent_id',
										'services_types.ordering as ordering',  
										'services_types.published as published'));
		
			$query->whereNull('deleted_at');
			$query->where('parent_id',$parent_id);
			if($length != '-1'){
				$query->skip($start)->take($length);
			}
			if( isset($filter['search']) && strlen($filter['search']) > 0 ){
				$query->where('services_types.title', 'LIKE', '%'. $filter['search'] .'%')->orWhere('services_types.price', 'LIKE', '%'. $filter['search'] .'%');
			}
			$query->orderBy($sort_field, $sort_dir);
			$data = $query->get();
			$count  = DB::select( DB::raw("SELECT FOUND_ROWS() AS recordsTotal;"))[0];
			$return['data'] = $data;
			$return['count'] = $count->recordsTotal;
			return $return;
    }
}
