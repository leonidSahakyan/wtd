<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Order;
use App\Models\Admin\Logger;
use App\Models\Product;
// use App\Models\Admin\Gallery;
use App\Models\Admin\Collection;

class OrderController extends Controller
{
    public function index(){
        $collections = Collection::select('id','title')->where('status',1)->whereNull('deleted_at')->get();

        view()->share('collections', $collections);
        view()->share('menu', 'orders');
        return view('admin.orders');
    }
    
    public function getOrder(Request $request){
        $id = (int)$request['id'];
        if(!$id) return 'error';
        
        $order = Order::select('*')->where('id', $id)->first();
        $orderItems =  DB::table('order_items')->where('order_id',$order->id)->get();
        $productModel = new Product();
        foreach($orderItems as $key => $orderItem){
            $product = $productModel->getProductWithImage($orderItem->product_id,isset($orderItem->color) ? $orderItem->color: false);
            if(isset($product->filename)){
                $imagePath = asset('images/productAdmin/'.$product->filename.'.'.$product->ext.''); 
            }else{
                $imagePath = asset('asset/img/product-detail-nav-1'); 
            }
            $orderItems[$key]->slug = $product->slug;
            $orderItems[$key]->collection = $product->collection;
            $orderItems[$key]->description = $product->description;
            $orderItems[$key]->sku = $product->sku;
            $orderItems[$key]->imagePath = $imagePath;
        }

        $country = DB::table('countries')->select('title')->where('id',$order->country_id)->first();
        $logs =  DB::table('log')->where('owner_id',$order->id)->where('owner_type', 'order')->orderBy('created_at','desc')->get();
        
        $invoce = false;
        if($order->is_paid){
            $query = DB::table('invoices');
            $query->select('invoices.hash','invoices.created_at as created','billings.amount_total as amount','billings.created_at as paid','billings.type','billings.paypal_transaction_id')->where('invoices.order_id', $order->id)->where('invoices.status','paid');
            $query->leftJoin('billings', 'billings.invoice_hash', '=', 'invoices.hash');
            $invoce =  $query->first();
        }

        $data = [
            'item'=>$order,
            'invoce'=>$invoce,
            'orderItems'=>$orderItems,
            'logs'=>$logs,
            'country'=>$country->title,
        ];

        $template = view('admin.order', $data)->render();
        $res = [
            'data' => $template,
            'status' => 1
        ];
        return response()->json($res);
    }

    public function data(Request $request){
        $model = new Order();

        $filter = array(
            'status' => $request->input('filter_status'),
            'search' => $request->input('search'),
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

    public function saveOrder(Request $request){
        $id = (int)$request['id'];
        if(!$id) return 'error';
        $status = $request->status;
        $comment = $request->comment;

        $order = Order::find($id);
        $message = 'Saved!';
        if($status && $status != $order->status){
            $payload = json_encode(array('old_status'=>$order->status,'new_status'=>$status));
            Logger::create(['owner_id' => $order->id,'type' => 'status_changed','data'=>$payload,'created_at' => date("Y-m-d H:i:s"),'owner_type' => 'order']);

            // $data = [
            //     'sku' => $order->sku,
            //     'hash' => $order->hash,
            //     'email' => $order->email,
            //     'phone' => $order->phone
            // ];
            // if($status == 'scheduled'){
            //     event(new SendNotification('order_scheduled',$data));
            // }
            // if($status == 'done'){
            //     event(new SendNotification('order_done',$data));
            // }
            // if($status == 'canceled'){
            //     event(new SendNotification('order_canceled',$data));      
            // }

            $order->status = $status;
            $message = 'Status changed';   
        }
        $order->comment = $comment;
        $order->save();
        return json_encode(array('status' => 1, 'message' => $message));
    }
}