<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Order;
use App\Models\Admin\Gallery;

class OrderController extends Controller
{
    public function index(){
        view()->share('menu', 'orders');
        return view('admin.orders');
    }
    
    public function getOrder(Request $request){
        $id = (int)$request['id'];
        if(!$id) return 'error';
        
        $query = DB::table('orders');
        $query->select('orders.*','services.title','services_types.title as service_type_title')->where('orders.id', $id);
        $query->leftJoin('services', 'services.id', '=', 'orders.service_id');
        $query->leftJoin('services_types', 'services_types.id', '=', 'orders.service_type');
        $item =  $query->first();

        $hasGallery = false;
        if($item->status != 'new'){
            if($item->review_gallery_id == null){
                $model = new Gallery();
                $model->temp = 0;
                $model->save();
                $item->review_gallery_id = $model->id;
                DB::table('orders')->where('id', $item->id)->update(['review_gallery_id' => $model->id]);
            }
            $hasGallery = true;
        }
        $orderUploads = DB::table('images')->select('filename','ext')->where('parent_id', $item->gallery_id)->get();
        
        $orderReplacement =  DB::table('order_replacement')->where('order_id',$item->id)->get();
        
        $masters =  DB::table('admin')->select('id','name','last_name')->where('role','master')->get();

        $logs =  DB::table('log')->where('owner_id',$item->id)->whereIn('type', ['order_created', 'order_paid'])->orderBy('created_at','desc')->get();
        
        $data = json_encode(
            array('data' => 
                (String) view('admin.order', array('item'=>$item,
                                                    'orderReplacement'=>$orderReplacement,
                                                    'hasGallery'=>$hasGallery,
                                                    'orderUploads'=>$orderUploads,
                                                    'logs'=>$logs,
                                                    'masters'=>$masters,
                                                )),'status' => 1)
            );
        return $data; 
    }

    public function data(Request $request){
        $model = new Order();

        $filter = array(
            'status' => $request->input('filter_status'),
            'type' => $request->input('filter_type'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        );

        $items = $model->getAll(
            $request->input('start'),
            $request->input('length'),
            $filter,
            $request->input('sort_field'),
            $request->input('sort_dir'),
        );

        $data = json_encode(array('data' => $items['data'], 'recordsFiltered' => $items['count'], 'recordsTotal'=> $items['count']));
        return $data;
    }

    public function saveOverview(Request $request){
        $id = (int)$request['id'];
        if(!$id) return 'error';

        $masterId = $request->master_id;
        $order = Order::find($id);
        $masterMessage = 'Nothing to update';
        if($masterId != $order->master_id){
            if($order->master_id && $masterId == 0){
                $masterMessage = 'Master successfully unassigned from order';
            }
            if(!$order->master_id && $masterId > 0){
                $masterMessage = 'Master successfully assigned to order';
            }
            if($order->master_id && $masterId > 0){
                $masterMessage = 'Master successfully changed';
            }
            $order->master_id = $masterId;
            //TODO Notification to master
            $order->save();
        }
        return json_encode(array('status' => 1, 'message' => $masterMessage));
    }
    public function saveReview(Request $request){
        $id = (int)$request['id'];
        if(!$id) return 'error';
        $review = $request['review'];

        $order = Order::find($id);
        $order->master_review = $review;
        $order->save();

        return json_encode(array('status' => 1, 'message' => "Success"));
    }
    public function saveNotes(Request $request){
        $id = (int)$request['id'];
        if(!$id) return 'error';
        $notes = $request['notes'];

        $order = Order::find($id);
        $order->notes = $notes;
        $order->save();

        return json_encode(array('status' => 1, 'message' => "Success"));
    }
    // public  function build_options_tree($cats,$parent_id,$hh,$self,$disabelChiled,$selectedArray){
        
    //     $hh = $hh.'--';
        
    //     if(!is_array($cats) || !isset($cats[$parent_id])){
    //          return null;
    //     }

    //     $tree = '';

    //     foreach($cats[$parent_id] as $cat){
    //         $catId = $cat["id"];
    //         $catParentId = $cat["parent_id"];
    //         $catTitle = $cat["title"];
            
    //         $disabled = false;
    //         $selected = false;

    //         // If Set some self category
    //         if($self){
    //             $selfId = $self["id"];
    //             $selfParentId = $self["parent_id"];

    //             // Self or this or parent of this category, or self chiled 
    //             if(($catParentId === $selfId) || $catId == $selfId){//$disabelChiled
    //                 $disabelChiled = true;
    //                 $disabled = true;
    //             }

    //             //if this category is parent of self category
    //             if($catId == $selfParentId){
    //                 $selected = true;
    //             }
    //         }

    //         if($selectedArray && in_array($catId,$selectedArray)){
    //             $selected = true;
    //         }

    //         $disabled = $disabled ? 'disabled' : '';
    //         $selected = $selected ? 'selected="selected"' : '';

    //         $tree .= '<option '.$disabled.' '.$selected.' value='.$catId.'>'.$hh.' '.$catTitle.'</option>';
    //         $tree .= $this->build_options_tree($cats,$catId,$hh,$self,$disabelChiled,$selectedArray);
    //     }
    //     return $tree;
    // }
}