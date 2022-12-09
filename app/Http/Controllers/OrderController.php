<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceReplacement;
use App\Models\OrderReplacement;
use App\Models\ServiceTypes;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Maintenance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Admin\Logger;
use App\Models\Gallery;
use App\Events\SendNotification;
use Stripe;

class OrderController extends Controller
{

    public function getHash(){
        $c = uniqid (rand (),true);
        $md5c = md5($c);
        return $md5c;
    }
    public function getSku($prefix){
        $sku = uniqid($prefix);
        return $sku;
    }
    public function getInvoice($prefix){
        $inv = uniqid('INV-'.$prefix);
        return $inv;
    }
    public function maintenance()
    {
        $priceResidential = DB::table('settings')->where('key',"price1")->first();
        $priceCommercial = DB::table('settings')->where('key',"price2")->first();

        view()->share('menu', 'maintenance');
        view()->share('priceResidential', $priceResidential->value);
        view()->share('priceCommercial', $priceCommercial->value);
        return view('app.maintenance');
    }
    public function homeOwner()
    {   
        // $data = [
        //     'order_id' => 1,
        //     'notification_type' => 'OrderPaid'
        // ];

        // event(new SendNotification($data));
        // exit();
        $model = New Order;
        $services = Service::whereNull('deleted_at')->where('published',1)->where('for_homeowner',1)->get();
        $serviceTypes = ServiceTypes::whereNull('deleted_at')->where('published',1)->get();
        $serviceReplacementices = ServiceReplacement::whereNull('deleted_at')->where('published',1)->get();
        $miniday = $model->forMiniday();
        
        $gallery = new Gallery();
        $gallery->save();

        view()->share('galleryId', $gallery->id);
        view()->share('menu', 'home-owner');
        view()->share('services', $services);
        view()->share('serviceTypes', $serviceTypes);
        view()->share('miniday', $miniday);
        view()->share('serviceReplacementices', $serviceReplacementices);

        return view('app.home-owner');
    }

    public function maintenanceCreate(Request $request)
    {
        // $request->validate([
        //     'first_name'      => 'required|string|max:255',
        //     'last_name'       => 'required|string|max:255',
        //     'new_gallery_id'  => 'required|int',
        //     'phone'           => 'required',
        //     'address'         => 'required',
        //     'service'         => 'required',
        //     'email'           => 'required',
        // ]);
        
        $maintenance = new Maintenance();
        $maintenance->sku =  $this->getSku("M-");
        $maintenance->hash =  $hash  = $this->getHash();
        
        $maintenance->first_name    = $request->first_name;
        $maintenance->last_name     = $request->last_name;
        $maintenance->address       = $request->address;
        $maintenance->email         = $request->email;
        $maintenance->phone         = $request->phone;
        $maintenance->system_type   = $request->system_type;
        $maintenance->company_name  = $request->company_name;
        $maintenance->second_type   = $request->location_type;
        $maintenance->years         = $request->years;
        $maintenance->website         = $request->website;
        $maintenance->comment       = $request->comment;
        $submittedPrice             = $request->total_price;

        if($maintenance->second_type == 'residential'){
            $price = DB::table('settings')->where('key',"price1")->first();
        }else{
            $price = DB::table('settings')->where('key',"price2")->first();
        }

        $total = $price->value * $maintenance->years;
        if($total != $submittedPrice)
        {
            return json_encode(array('status' => 0,'message'=>"Something wrong with price, pls try again"));
        }
        
        $maintenance->price = $price->value;
        $maintenance->total = $total;

        if($maintenance->save()){
            Logger::create(['owner_id' => $maintenance->id,'type' => 'maintenance_created','created_at' => date("Y-m-d H:i:s")]);
            return json_encode(['status'=>1,'hash'=>$hash]);
        }else{
            return json_encode(array('status' => 0,'message'=>"Something wrong with price, pls try again"));
        }
    }

    public function maintenanceSign($hash)
    {
        $data = Maintenance::where('hash', $hash)->where('status','new')->firstOrFail();
        view()->share('data', $data);
        return view('app.maintenance_sign');
    }
    public function create(Request $request)
    {
        // $request->validate([
        //     'first_name'      => 'required|string|max:255',
        //     'last_name'       => 'required|string|max:255',
        //     'new_gallery_id'  => 'required|int',
        //     'phone'           => 'required',
        //     'address'         => 'required',
        //     'service'         => 'required',
        //     'email'           => 'required',
        // ]);
        
        $order = new Order();
        $orderData = array();
        $orderData['replacment'] = array();

        $order->sku =  $this->getSku("O-");
        $order->hash =  $hash  = $this->getHash();
        
        $order->first_name = $request->first_name;
        //TODO set gallery temp 0
        $order->gallery_id = $request->gallery_id;
        $order->last_name  = $request->last_name;
        $order->address    = $request->address;
        $order->email      = $request->email;
        $order->phone      = $request->phone;
        $order->find_us    = $request->find_us;
        $order->service_id = $request->service;
        $order->order_date = $request->order_date;
        $order->order_time = $request->order_time;
        $order->comment = $request->comment;
        $order->second_type = $request->location_type;
        $submittedPrice     = $request->total_price;
        
        $serviceId = $request->service;

        $serviceTypeTitle = 'service_type_'.$serviceId;
        $serviceType = $request->$serviceTypeTitle;
        $serviceTypeOther = null;

        //Todo Service type requierd ? 
        if($serviceType == "-1"){
            $serviceTypeOther = $request->service_other_type;
            $order->service_type = null;
            $order->service_type_other = $serviceTypeOther;
            // $orderData['serviceTypeOther'] = $serviceTypeOther;
            // $orderData['serviceType'] = "Other: ".$serviceType;
        }else{
            // $serviceTypeObj =  ServiceTypes::select('title')->where("published",1)->where("id",$serviceType)->first();
            // $orderData['serviceType'] = $serviceTypeObj->title;
            $order->service_type = $serviceType;
        }  

        $service =  Service::select('id','residential_price','commercial_price')->where("published",1)->where("id",$serviceId)->first();
        
        $serviceReplacment =  ServiceReplacement::select('id','price','title')->where("published",1)->where("parent_id",$serviceId)->get();
        $replacmentPrice = 0;
        $replacmentData = array();
        foreach($serviceReplacment as $replacment){
            $replacment->price = $replacment->price > 0 ? $replacment->price : 0; 
            $replacmentTitle = "service_replacement_".$replacment->id;
            if($request->$replacmentTitle){
                $replacmentQtyTitle = "service_replacement_qty_".$replacment->id;
                $replacmentQty = $request->$replacmentQtyTitle;
                $replacmentData[]  = array(
                    'replacment_id'=>$request->$replacmentTitle,
                    'qty'=>$replacmentQty,
                    'price'=>$replacment->price,
                    'title'=>$replacment->title,
                );
                // $orderData['replacment'][] = array('id'=>$request->$replacmentTitle,'qty'=>$replacmentQty,'price'=>$replacment->price,'title'=>$replacment->title);
                if($replacment->price > 0){
                    $replacmentPrice = $replacmentPrice + ($replacmentQty * $replacment->price);
                }
            }
        }
        $servicePrice = $order->second_type == 'residential' ?  $service->residential_price : $service->commercial_price;
        $total = $replacmentPrice + $servicePrice;

        if($total != $submittedPrice)
        {
            return json_encode(array('status' => 0,'message'=>"Something wrong with price, pls try again"));
        }
        $order->service_price = $servicePrice;
        $order->replacment_price = $replacmentPrice;
        $order->total = $total;

        if($order->save()){
            Logger::create(['owner_id' => $order->id,'type' => 'order_created','created_at' => date("Y-m-d H:i:s")]);
            foreach($replacmentData as $key => $rd){
                $replacmentData[$key]['order_id'] = $order->id; 
            }
            OrderReplacement::insert($replacmentData);
            return json_encode(['status'=>1,'hash'=>$hash]);
        }else{
            return json_encode(array('status' => 0,'message'=>"Something wrong with price, pls try again"));
        }
    }

    public function processToCheckout(Request $request){
        $hash = $request->hash;
        $method = $request->method;

        $query = DB::table('orders');
        $query->select('orders.*','services.title','services_types.title as service_type_title');
        $query->where('orders.hash', $hash);
        $query->leftJoin('services', 'services.id', '=', 'orders.service_id');
        $query->leftJoin('services_types', 'services_types.id', '=', 'orders.service_type');
        $data = $query->first();
        
        $siteUrl = ENV('APP_URL');
        $invoice   = new Invoice();
        $invoice->order_id = $data->id;
        $invoice->status = 'new';
        $invoice->hash = $this->getInvoice('ORDER');
        $invoice->save();
        if(!$invoice->id){
            return false;
        }
        if($method == 'stripe'){
            Stripe\Stripe::setApiKey(ENV('STRIPE_SECRET'));
            $checkout_session = \Stripe\Checkout\Session::create([
                'client_reference_id' => $invoice->hash,
                'payment_method_types' => ['card'],
                'customer_email' => $data->email,
                'line_items' => [[
                    'price_data' => [
                        'currency' => "USD",
                        'unit_amount' =>$data->total * 100,
                        'product_data' => ['name' => $data->title],
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => $siteUrl . '/success/'.$hash,
                'cancel_url' => $siteUrl . '/checkout/'.$hash,
            ]);
            return response()->json(['status' => 1, 'redirect_url'=> $checkout_session->id ]);
        }
        if($method == 'paypal'){
            $provider = \PayPal::setProvider();
            $provider->getAccessToken();

            $data = json_decode('{
                "intent": "CAPTURE",
                "purchase_units": [
                  {
                    "amount": {
                      "currency_code": "USD",
                      "value": "'.$data->total.'"
                    }
                  }
                ]
            }', true);
            
            $order = $provider->createOrder($data);
            if(!$order['id'] || $order['status'] != 'CREATED'){
                return response()->json(['status' => 0, 'message'=> "Something wet wrong" ]);
            }
            $invoice->paypal_order_id = $order['id'];
            if($invoice->save()){
                return response()->json($order);
            }
        }
        return response()->json(['status' => 0, 'message'=> "Something wet wrong, pls try again" ]);
    }

    public function checkout($hash)
    {
        $query = DB::table('orders');
        $query->select('orders.*','services.title','services_types.title as service_type_title');
        $query->where('orders.hash', $hash);
        $query->leftJoin('services', 'services.id', '=', 'orders.service_id');
        $query->leftJoin('services_types', 'services_types.id', '=', 'orders.service_type');
        $data = $query->first();
        if(!$data || $data->status != 'new'){ //TODO
            return "This order already expaierd, you can pay for it";
        }
        $orderReplacement =  DB::table('order_replacement')->where('order_id',$data->id)->get();
        
        view()->share('orderReplacement', $orderReplacement);
        view()->share('data', $data);
        view()->share('menu', 'checkout');
        return view('app.checkout');
    }
    private function orderPorccessingFaild($session){
        $invoiceHash = $session->client_reference_id;

        $invoice = Invoice::where('hash',$invoiceHash)->first();
        if(!$invoice){
            Log::critical('Cant find invoice');
            Log::critical($invoiceHash);
            return false;  
        }
        if($invoice->status == 'pending' || $invoice->status == 'new'){
            DB::table('invoices')->where('id', $invoice->id)->update(['status' => 'canceled']);
        }
    }
    private function orderPorccessing($session){
        $session_id = $session->id;
        $invoiceHash = $session->client_reference_id;
        $payment_intent = $session->payment_intent;
        $amount = $session->amount_total;
        
        $invoice = Invoice::where('hash',$invoiceHash)->first();
        if(!$invoice){
            Log::critical('Cant find invoice');
            Log::critical($invoiceHash);
            return false;  
        }
        
        if($invoice->status == 'pending' || $invoice->status == 'new'){
            DB::beginTransaction();

            try {
                DB::table('invoices')->where('id', $invoice->id)->update(['status' => 'paid']);
                DB::table('stripe_payments')->insert([
                    'payment_intent' => $payment_intent,
                    'invoice_hash' => $invoiceHash,
                    'session_id' => $session_id,
                    'amount_total' => $amount,
                ]);
                DB::table('orders')->where('id', $invoice->order_id)->update(['status' => 'paid']);
                DB::table('log')->insert(['owner_id' => $invoice->order_id,'type' => 'order_paid','created_at' => date("Y-m-d H:i:s")]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                Log::critical('Cant handle stripe payment, rollback DB, evt: checkout.session.completed');
                return false;
            }

            $data = [
                'order_id' => $invoice->order_id,
                'notification_type' => 'OrderPaid'
            ];
    
            event(new SendNotification($data));
        }
        return true;
    }
    public function checkoutSuccess($hash){
        $order = Order::select('sku','hash')->where('hash', $hash)->first();
        
        view()->share('order', $order);
        return view('app.checkout_success');   
    }
    public function checkoutFail($hash){
        $order = Order::select('sku','hash')->where('hash', $hash)->first();
        if(!$order){
            return redirect('/404');
        }
        if($order->status != 'new'){
            return redirect('/order/'.$hash);
        }
        view()->share('order', $order);
        return view('app.checkout_fail');   
    }
    public function order($hash){
        $query = DB::table('orders');

        $query->select('orders.*','services.title','services_types.title as service_type_title');
        $query->where('orders.hash', $hash);
        $query->leftJoin('services', 'services.id', '=', 'orders.service_id');
        $query->leftJoin('services_types', 'services_types.id', '=', 'orders.service_type');
        $data = $query->first();

        $orderReplacement =  DB::table('order_replacement')->where('order_id',$data->id)->get();
        view()->share('orderReplacement', $orderReplacement);
        view()->share('data', $data);
        return view('app.order');  
    }
    public function handlePaypal(Request $request){
        $orderId = $request->orderId;
        $provider = \PayPal::setProvider();
        $provider->getAccessToken();

        $invoice = Invoice::where('paypal_order_id',$orderId)->first();
        if(!$invoice){
            Log::critical('Cant find invoice, paypal');
            Log::critical($orderId);
            return false;  
        }
        
        $order = $provider->capturePaymentOrder($orderId);
        if($order['status'] == 'COMPLETED'){
            if($invoice->status == 'pending' || $invoice->status == 'new'){
                DB::beginTransaction();
    
                try {
                    DB::table('invoices')->where('id', $invoice->id)->update(['status' => 'paid']);
                    DB::table('orders')->where('id', $invoice->order_id)->update(['status' => 'paid']);
                    DB::table('log')->insert(['owner_id' => $invoice->order_id,'type' => 'order_paid','created_at' => date("Y-m-d H:i:s")]);
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();
                    Log::critical('Cant handle paypal payment, rollback DB, evt: COMPLETED');
                    return false;
                }
                return response()->json($order);
            }
        }
        return response()->json(['status' => 0, 'message'=> "Something wet wrong" ]);
    }
    public function handleStripe(){
        $endpoint_secret = ENV('STRIPE_WEBHOOK_SECRET');
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        
        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch(\UnexpectedValueException $e) {
            http_response_code(400);
            exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            http_response_code(400);
            exit();
        }

        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $invoiceHash = $session->client_reference_id;
                $invoice = Invoice::where('hash',$invoiceHash)->first();
                if($invoice->status == 'new'){
                    $invoice->status = 'pending';
                    $invoice->save();   
                }
                if ($session->payment_status == 'paid') {
                    $this->orderPorccessing($session);
                }
            break;
            case 'checkout.session.async_payment_succeeded':
                $session = $event->data->object;
                $this->orderPorccessing($session);
            break;
            case 'checkout.session.async_payment_failed':
                $session = $event->data->object;
                $this->orderPorccessingFaild($session);
            break;
        }
        http_response_code(200);
    }
}