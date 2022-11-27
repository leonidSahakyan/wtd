<?php

namespace App\Listeners;

use App\Events\SendNotification;
use App\Mail\OrderPaid;
use App\Mail\NewOrder;
use App\Mail\AdminInvitation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\Sms;

class SendNotificationEmail
{
    /**
     * Handle the event.
     *
     * @param  SendNotification  $event
     * @return void
     */
    public function handle(SendNotification $event)
    {
        $notification_type = $event->data['notification_type'];
        unset($event->data['notification_type']);

        if($notification_type == 'AdminInvitation'){
            Mail::to($event->data['email'])->send(new AdminInvitation($event->data));
        }

        if($notification_type == 'OrderPaid'){
            $orderId = (int)$event->data['order_id'];

            $order = DB::table('orders')->select('sku','hash','email')->where('id',$orderId)->first();
            $event->data['sku'] = $order->sku;
            $event->data['hash'] = $order->hash;
            $event->data['email'] = $order->email;

            Mail::to($event->data['email'])->send(new OrderPaid($event->data));

            $adminMail = DB::table('admin')->select('email','phone')->where('role','superadmin')->first();
            if($adminMail->email){
                Mail::to($adminMail->email)->send(new NewOrder($event->data));
            }
            $message = "New order!\nOrder ".$order->sku." successfully paid.";
            Sms::send($adminMail->phone,$message);
        }
    }
}
