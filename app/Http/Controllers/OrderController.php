<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Str;
use App\Models\OrderItems;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Admin\Logger;
use App\Events\SendNotification;

class OrderController extends Controller
{

    public function checkout(Request $request){
        $request->validate([
            'first_name'      => 'required|string|max:100',
            'last_name'       => 'required|string|max:100',
            'email'       => 'required|email:rfc',
            'phone'           => 'required|string|max:30',
            'shipping_country'      => 'required|int|exists:countries,id,status,1',
            'city'      => 'required|string',
            'address'       => 'required|string',
            'post_code'       => 'nullable|string',
            'notes'       => 'nullable|string',
            'cart_data.*'       => 'required|string',
            'qty.*'       => 'required|int',
            'total'       => 'required|int',
        ]);
        
        $submittedPrice = (int)$request->total;
        $cart_data = $request->cart_data;
        $qty = $request->qty;

        $itemsTotal = 0;
        $subTotal = 0;
        $totalQty = 0;
        $orderData = [];
        foreach($cart_data as $key => $cartItem){
            $item = json_decode($cartItem);
            $item->qty = $qty[$key];

            $product = DB::table('product')->select('id','title','price')->where('id',$item->id)->where('status',1)->first();
            if(!$product){
                return response()->json(['errors' => ['server' => 'Wrong total']], 422);
            }

            $orderData[]  = array(
                'product_id'=>$product->id,
                'qty'=>$qty[$key],
                'color'=> isset($item->color) ? $item->color : null,
                'size'=> isset($item->size) ? $item->size : null,
                'price'=> $product->price,
                'title'=>$product->title,
            );

            $subTotal = $item->qty * $product->price;
            $totalQty += $item->qty;
            $itemsTotal += $subTotal;
        }
        $shippingPrice = DB::table('countries')->select('price')->where('id',$request->shipping_country)->where('status',1)->first();
        //TODO need fix
        $total = $itemsTotal + $shippingPrice->price;
        if($submittedPrice != $total){
            return response()->json(['errors' => ['server' => 'Wrong total']], 422);
        }
        if(count($orderData) < 1){
            return response()->json(['errors' => ['server' => 'Wrong order data']], 422);
        }
        $order = new Order();
        $order->sku =  uniqid("O-");
        $order->hash =  Str::uuid()->toString();
        $order->first_name = $request->first_name;
        $order->last_name  = $request->last_name;
        $order->email      = $request->email;
        $order->phone      = $request->phone;
        $order->country_id = $request->shipping_country;
        $order->city    = $request->city;
        $order->data    = json_encode($orderData);
        $order->address    = $request->address;
        $order->notes = $request->notes;
        $order->post_code = $request->post_code;
        $order->qty    = $totalQty;
        $order->total    = $total;
        $order->shipping_price = $shippingPrice->price;
        $order->items_price = $itemsTotal;

        if($order->save()){
            Logger::create(['owner_id' => $order->id,'type' => 'order_created','owner_type' => 'order']);
            foreach($orderData as $key => $rd){
                $orderData[$key]['order_id'] = $order->id;
            }
            OrderItems::insert($orderData);
            return json_encode(['status'=>1,'hash'=>$order->hash]);
        }else{
            return response()->json(['errors' => ['server' => 'Wrong order data']], 422);
        }
    }
    public function processToCheckout(Request $request){
        $hash = $request->hash;

        $order = DB::table('orders')->where('status','new')->where('hash',$hash)->first();
        if(!$order)return false;

        $invoice   = new Invoice();
        $invoice->order_id = $order->id;
        $invoice->status = 'new';
        $invoice->hash = uniqid('INV-');
        $invoice->save();

        if(!$invoice->id)return false;
        $provider = \PayPal::setProvider();
        $provider->getAccessToken();

        $data = json_decode('{
            "intent": "CAPTURE",
            "purchase_units": [
                {
                "amount": {
                    "currency_code": "USD",
                    "value": "'.$order->total.'"
                }
                }
            ]
        }', true);
        
        $paypalOrder = $provider->createOrder($data);
        if(!$paypalOrder['id'] || $paypalOrder['status'] != 'CREATED'){
            return response()->json(['status' => 0, 'message'=> "Something wet wrong" ]);
        }
        $invoice->paypal_order_id = $paypalOrder['id'];
        if($invoice->save()){
            return response()->json($paypalOrder);
        }
        return response()->json(['status' => 0, 'message'=> "Something wet wrong, pls try again" ]);
    }
    public function handlePaypal(Request $request){
        $paypal_order_id = $request->paypal_order_id;
        $provider = \PayPal::setProvider();
        $provider->getAccessToken();

        $invoice = Invoice::where('paypal_order_id',$paypal_order_id)->first();
        if(!$invoice){
            Log::critical('Cant find invoice, paypal');
            Log::critical($paypal_order_id);
            return false;
        }

        $order = $provider->capturePaymentOrder($paypal_order_id);
        if(isset($order['status']) && $order['status'] == 'COMPLETED'){
            $data = false;
            $data = Order::find($invoice->order_id);

            if(!$data){
                Log::critical('Cant find payment owner, paypal');
                Log::critical($invoice->order_id);
                return response()->json(['status' => 2, 'redirect_url'=> route('checkout_success_fail',['hash' => $data->hash])  ]);
                return false;
            }

            $trxId = $order['purchase_units'][0]['payments']['captures'][0]['id'];
            $currency = $order['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'];
            $amount = $order['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
            
            if($currency != "USD" || (int)$amount != $data->total){
                Log::critical('Cant handle paypal payment, something wrong with amount, evt: COMPLETED');   
                Log::critical('InvoiceId:'.$invoice->id);
                return response()->json(['status' => 2, 'redirect_url'=> route('checkout_success_fail',['hash' => $data->hash])  ]);
            }
            DB::beginTransaction();

            try {
                DB::table('invoices')->where('id', $invoice->id)->update(['status' => 'paid']);
                DB::table('billings')->insert([
                    'invoice_hash' => $invoice->hash,
                    'paypal_order_id' => $paypal_order_id,
                    'paypal_transaction_id' => $trxId,
                    'amount_total' => $amount,
                    'type' => 'paypal',
                ]);

                DB::table('orders')->where('id', $data->id)->update(['status' => 'paid','is_paid' => 1]);
                DB::table('log')->insert(['owner_id' => $invoice->order_id,'type' => 'order_paid','owner_type' => 'order','created_at' => date("Y-m-d H:i:s")]);
            
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                Log::critical('Cant handle paypal payment, rollback DB, evt: COMPLETED');
                Log::critical('Error'.$e);
                return response()->json(['status' => 2,'redirect_url'=> route('checkout_success_fail',['hash' => $data->hash])  ]);
            }
            
            \Session::forget('cart');

            event(new SendNotification('order_paid',['id'=>$invoice->order_id]));
            return response()->json(['status' => 1, 'redirect_url'=> route('checkout_success',['hash' => $data->hash]) ]);
        }
        return response()->json(['status' => 0, 'message'=> "Something wet wrong, pls try again" ]);
    }
    public function checkoutSuccess($hash){
        $order = Order::select('sku','hash')->where('hash', $hash)->where('status','paid')->firstOrFail();

        view()->share('menu', false);
        view()->share('order', $order);
        return view('app.checkout_success');
    }
    public function checkoutFail($hash){
        $order = Order::select('sku','hash')->where('hash', $hash)->where('status','new')->firstOrFail();
        
        view()->share('menu', false);
        view()->share('order', $order); 
        return view('app.checkout_fail');
    }
    
    public function checkoutSuccessFail($hash){
        $order = Order::select('sku','hash')->where('hash', $hash)->where('status','new')->firstOrFail();
        
        view()->share('menu', false);
        view()->share('order', $order);
        return view('app.checkout_success_fail');   
    }
    public function order($hash){
        $order = Order::select('*')->where('hash', $hash)->where('status','!=','new')->firstOrFail();
        $orderItems =  DB::table('order_items')->where('order_id',$order->id)->get();
        $productModel = new Product();
        foreach($orderItems as $key => $orderItem){
            $product = $productModel->getProductWithImage($orderItem->product_id,isset($orderItem->color) ? $orderItem->color: false);
            if($product->filename){
                $imagePath = asset('images/productList/'.$product->filename.'.'.$product->ext.''); 
            }else{
                $imagePath = asset('asset/img/product-detail-1.jpg'); 
            }
            $orderItems[$key]->slug = $product->slug;
            $orderItems[$key]->sku = $product->sku;
            $orderItems[$key]->imagePath = $imagePath;
        }

        $country = DB::table('countries')->select('title')->where('id',$order->country_id)->first();
        view()->share('country', $country->title);
        
        view()->share('orderItems', $orderItems);
        view()->share('menu', false);
        view()->share('order', $order);
        return view('app.order');
    }
}