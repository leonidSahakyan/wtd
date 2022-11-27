<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Card extends Model
{
	use SoftDeletes;
    use HasFactory;
    protected $table = 'card';
	public $timestamps = false;

    public function getAll($start,$length,$filter,$sort_field,$sort_dir){
    	$query = DB::table($this->table);

		$query->select(array(DB::raw('SQL_CALC_FOUND_ROWS card.id'), 
										'card.id as DT_RowId',
										'card.name as name',
										'card.type as type',
										'card.ps_total as ps_total',
										'card.published as published'
										)
								);
		
		if($length != '-1'){
			$query->skip($start)->take($length);
		}

		if( isset($filter['search']) && strlen($filter['search']) > 0 ){
			$query->where('card.name', 'LIKE', '%'. $filter['search'] .'%');
		}

		if(isset($filter['status'])){
			$query->where('card.published',$filter['status']);    
		}
		
		$query->where('card.deleted_at',null);

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
