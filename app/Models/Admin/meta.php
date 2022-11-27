<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class meta extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'meta';


    public $timestamps  = false;

    public function getAll($start,$length,$filter,$sort_field,$sort_dir){

        $query = DB::table('meta');

        $query->select(array(DB::raw('SQL_CALC_FOUND_ROWS meta.id'),
            'meta.id as DT_RowId',
            'meta.pagename as pagename',
            'meta.title as title',
            'meta.published as published'));

        if($length != '-1'){
            $query->skip($start)->take($length);
        }
        if( isset($filter['search']) && strlen($filter['search']) > 0 ){
            $query->where('meta.title', 'LIKE', '%'. $filter['search'] .'%')->orWhere('meta.pagename', 'LIKE', '%'. $filter['search'] .'%');
        }
        $query->orderBy($sort_field, $sort_dir);
        $data = $query->get();
        $count  = DB::select( DB::raw("SELECT FOUND_ROWS() AS recordsTotal;"))[0];
        $return['data'] = $data;
        $return['count'] = $count->recordsTotal;
        return $return;
    }

}
