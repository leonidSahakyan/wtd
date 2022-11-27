<?php

namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin';
    protected $guard = 'admin';
    protected $guarded = array('admin');

    protected $fillable = [
        'username', 'password',
    ];

    public function getAll($start,$length,$filter,$sort_field,$sort_dir){
    	$query = DB::table('admin');

		$query->select(array(DB::raw('SQL_CALC_FOUND_ROWS admin.id'), 
										'admin.id as DT_RowId',
										'admin.name',
										'admin.last_name',
										'admin.phone',
										'admin.email'));
		

		if($length != '-1'){
			$query->skip($start)->take($length);
		}
		
        $query->where('admin.role','master');
		if( isset($filter['search']) && strlen($filter['search']) > 0 ){
			$query->where('admin.name', 'LIKE', '%'. $filter['search'] .'%')
            ->orWhere('admin.last_name', 'LIKE', '%'. $filter['search'] .'%')
            ->orWhere('admin.email', 'LIKE', '%'. $filter['search'] .'%')
            ->orWhere('admin.phone', 'LIKE', '%'. $filter['search'] .'%');
		}
		
		$query->orderBy($sort_field, $sort_dir);
		$data = $query->get();

		$count  = DB::select( DB::raw("SELECT FOUND_ROWS() AS recordsTotal;"))[0];

		$return['data'] = $data;
		$return['count'] = $count->recordsTotal;
    	return $return;
    }
}