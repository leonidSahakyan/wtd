<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Users extends Model
{
    use HasFactory;
	protected $table = 'users';
	
	public function getAll($start,$length,$filter,$sort_field,$sort_dir){
    	$query = DB::table('users');

		$query->select(array(DB::raw('SQL_CALC_FOUND_ROWS users.id'), 
										'users.id as DT_RowId',
										'users.first_name',
										'users.last_name',
										'users.email',
										));
										             
		if($length != '-1'){
			$query->skip($start)->take($length);
		}
		if( isset($filter['search']) && strlen($filter['search']) > 0 ){
			$query->where('users.first_name', 'LIKE', '%'. $filter['search'] .'%')->orWhere('users.last_name', 'LIKE', '%'. $filter['search'] .'%');
		}
		$query->orderBy($sort_field, $sort_dir);
		$data = $query->get();
		$count  = DB::select( DB::raw("SELECT FOUND_ROWS() AS recordsTotal;"))[0];
		$return['data'] = $data;
		$return['count'] = $count->recordsTotal;
    	return $return;
    }

}