<?php

namespace App\Listeners;

use App\Events\SendNotification;
use App\Mail\DefaultMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\Sms;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotificationEmail implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  SendNotification  $event
     * @return void
     */
    public function handle(SendNotification $event)
    {
    
        if(in_array($event->type,['order_paid'])){
            $id = (int)$event->payload['id'];

            $order = DB::table('orders')->select('sku','hash','email')->where('id',$id)->first();
            $event->payload['sku'] = $order->sku;
            $event->payload['hash'] = $order->hash;
            $event->payload['email'] = $order->email;
            $event->payload['subject_data'] = ['sku' => $order->sku];

            $adminMail = DB::table('admin')->select('email')->first();

            Mail::to($event->payload['email'])->send(new DefaultMail($event));
            Mail::to($adminMail->email)->send(new DefaultMail($event));

            // if($adminMail->sms_notification){
            //     $message =  trans('sms.'.$event->type, ['sku' => $event->payload['sku']]);
            //     Sms::send($adminMail->phone,$message);
            // }
        }
        if(in_array($event->type,['order_shipping','order_done','order_canceled'])){
            $event->payload['subject_data'] = ['sku' => $event->payload['sku']];
            Mail::to($event->payload['email'])->send(new DefaultMail($event));    
        }
    }
}
