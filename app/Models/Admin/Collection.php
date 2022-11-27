<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Collection extends Model
{
	use SoftDeletes;
    protected $table = 'collections';
    public $timestamps = false;

    public function getAll($start,$length,$filter,$sort_field,$sort_dir){
    	$query = DB::table($this->table);

		$query->select(array(DB::raw('SQL_CALC_FOUND_ROWS collections.id'), 
										'collections.id as DT_RowId',
										'collections.title',
										'collections.status',
										'collections.ordering',
										)
								);
		
		if($length != '-1'){
			$query->skip($start)->take($length);
		}

		if( isset($filter['search']) && strlen($filter['search']) > 0 ){
			$query->where('collections.title', 'LIKE', '%'. $filter['search'] .'%');
		}

		if(isset($filter['status']) && $filter['status'] != -1){
			$query->where('collections.status',$filter['status']);    
		}

		$query->whereNull('collections.temp');
		$query->whereNull('collections.deleted_at');

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
