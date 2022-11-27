<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class Slider extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'slider';


    public $timestamps  = false;

    public function getAll($start,$length,$filter,$sort_field,$sort_dir){

        $query = DB::table('slider');

        $query->select(array(DB::raw('SQL_CALC_FOUND_ROWS slider.id'),
            'slider.id as DT_RowId',
            'slider.title as title',
            'slider.link as link',
            'slider.namebutton as namebutton',
            'slider.linktype as linktype',
            'slider.ordering as ordering',
            'slider.published as published'));

        if($length != '-1'){
            $query->skip($start)->take($length);
        }
        if( isset($filter['search']) && strlen($filter['search']) > 0 ){
            $query->where('slider.title', 'LIKE', '%'. $filter['search'] .'%')->orWhere('slider.price', 'LIKE', '%'. $filter['search'] .'%');
        }
        $query->orderBy($sort_field, $sort_dir);
        $data = $query->get();
        $count  = DB::select( DB::raw("SELECT FOUND_ROWS() AS recordsTotal;"))[0];
        $return['data'] = $data;
        $return['count'] = $count->recordsTotal;
        return $return;
    }
    public function forSlider1(){
        $slider1 =  DB::table('slider')->where('published',1)->get();
        $data1 = [];
        foreach ($slider1 as $slideData) {
            $item=DB::table('images')->where('id',$slideData->image_id)->get('filename');
            $newitem = [
                'title'       => $slideData->title,
                'namebutton'  => $slideData->namebutton,
                'link'        => $slideData->link,
                'linktype'    => $slideData->linktype,
                'description' => $slideData->description,
                'filename'    => $item[0]->filename,
            ];
            array_push($data1,$newitem);
        };
        return $data1;
    }
}
