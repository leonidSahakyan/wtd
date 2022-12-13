<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Dictionary extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dictionary';

    public $timestamps  = false;
    
    
    public function getAll($start,$length,$filter,$sort_field,$sort_dir){
    	$query = DB::table('dictionary');

		$query->select(array(DB::raw('SQL_CALC_FOUND_ROWS dictionary.key'),
		                             'dictionary.key as DT_RowId',
									 'dictionary.en as title','type'));
		if($length != '-1'){
			$query->skip($start)->take($length);
		}

		if ($filter){
			if ( strlen($filter['search']) ) {
				$search = $filter['search'];
				$query->where(function($query) use ($search){
					$query->where('key', 'LIKE', '%'.$search.'%')
						  ->orWhere('en', 'LIKE', '%'.$search.'%');
				});
    		}
		}
		if(isset($filter['type']) && $filter['type'] != -1 ){
			$query->where('dictionary.type',$filter['type']);    
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