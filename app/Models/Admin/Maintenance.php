<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Maintenance extends Model
{
    protected $table = 'maintenance';

    public function getAll($start,$length,$filter,$sort_field,$sort_dir){
        $query = DB::table('maintenance');

        $query->select(array(DB::raw('SQL_CALC_FOUND_ROWS maintenance.id'),
                'maintenance.id as DT_RowId',
                'maintenance.price',
                'maintenance.status',
                'maintenance.created_at',
            )
        );

        if($length != '-1'){
            $query->skip($start)->take($length);
        }

        if(isset($filter['status'])){
            $query->where('maintenance.status',$filter['status']);
        }

        // if(isset($filter['category']) &&  $filter['category'] != -1){
        // 	$query->where('categories.id',$filter['category']);
        // }
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
