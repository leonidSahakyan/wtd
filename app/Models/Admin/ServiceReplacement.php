<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class ServiceReplacement extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'services_replacement';

    
    public $timestamps  = false;
    
    public function getAll($start,$length,$filter,$sort_field,$sort_dir,$parent_id){

    	$query = DB::table('services_replacement');

		$query->select(array(DB::raw('SQL_CALC_FOUND_ROWS services_replacement.id'), 
										'services_replacement.id as DT_RowId', 
										'services_replacement.title as title',
										'services_replacement.parent_id as parent_id',
										'services_replacement.ordering as ordering',  
										'services_replacement.published as published'));
			
			$query->whereNull('deleted_at');
			$query->where('parent_id',$parent_id);
			if($length != '-1'){
				$query->skip($start)->take($length);
			}
			if( isset($filter['search']) && strlen($filter['search']) > 0 ){
				$query->where('services_replacement.title', 'LIKE', '%'. $filter['search'] .'%')->orWhere('services_replacement.price', 'LIKE', '%'. $filter['search'] .'%');
			}
			$query->orderBy($sort_field, $sort_dir);
			$data = $query->get();
			$count  = DB::select( DB::raw("SELECT FOUND_ROWS() AS recordsTotal;"))[0];
			$return['data'] = $data;
			$return['count'] = $count->recordsTotal;
			return $return;
    }
}
