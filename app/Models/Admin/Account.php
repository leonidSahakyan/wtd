<?php

namespace App\Models\Admin;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Account extends Model
{
	protected $table = "account";

    public function getAll($start,$length,$filter,$sort_field,$sort_dir){
    	$query = DB::table('account');

		$query->select(array(DB::raw('SQL_CALC_FOUND_ROWS account.id'), 
										'account.id as DT_RowId',
										'account.username',
										'account.password',
										'account.coins',
										'account.status',
										'account.type',
										'account.code_count',
										'users.id as user_id',
										)
								);
		$query->leftJoin('users', 'users.id', '=', 'account.user_id');

		if($length != '-1'){
			$query->skip($start)->take($length);
		}
		
		if( isset($filter['search']) && strlen($filter['search']) > 0 ){
			$query->where('users.email', 'LIKE', '%'. $filter['search'] .'%');
		}

		if(isset($filter['status'])){
			$query->where('account.status',$filter['status']);    
		}

		$query->orderBy($sort_field, $sort_dir);
		$data = $query->get();

		foreach ($data as $d) {
			$d->code_text = '123213';
			// if($d->code && strlen($d->code) > 0 && $d->code != ''){
			// 	$d->code = unserialize($d->code);
			// }else{
			// 	$d->code = "not found";
			// }
			$d->DT_RowId = "row_".$d->DT_RowId;
		}

		$count  = DB::select( DB::raw("SELECT FOUND_ROWS() AS recordsTotal;"))[0];

		$return['data'] = $data;
		$return['count'] = $count->recordsTotal;
    	return $return;
    }

	// public function code()
    // {
    //     return $this->hasMany(Code::class);
    // }

}