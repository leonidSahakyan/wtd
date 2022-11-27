<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use File;
use App\Models\Notification;


class CancelOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:cancelOrder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel order';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = new \DateTime;
        $date->modify('-15 minutes');
        $formatted_date = $date->format('Y-m-d H:i:s');

        $tempCategory = new \DateTime;
        $tempCategory->modify('-1 days');
        $formatted_date_cat = $tempCategory->format('Y-m-d H:i:s');

        $ordersForCancel = DB::table('orders')->where('status','waiting')->where('created_at',"<",$formatted_date)->get();
        if($ordersForCancel){
            foreach($ordersForCancel as $orderForCancel){
                $notification = new Notification();
                $notificationData = array('type' => 'order_request_timeout');
                $notification->send($orderForCancel->user_id,'notifications.order_timeout_title','notifications.order_timeout_text_customer',"order_request_timeout",$orderForCancel->id,$notificationData,true);
                $notification->send($orderForCancel->employee_id,'notifications.order_timeout_title','notifications.order_timeout_text_employee',"order_request_timeout",$orderForCancel->id,$notificationData,true);
            }
            DB::table('orders')->where('status','waiting')->where('created_at',"<",$formatted_date)->update(['status' => 'canceled']);
        }
                
        $catsForDelete =  DB::table('categories')->select('id','icon')->where('created_at',"<",$formatted_date_cat)->whereNotNull('temp')->get();
        if($catsForDelete){
            foreach($catsForDelete as $catForDelete){
                if($catForDelete->icon && $catForDelete->icon != null){
                    $path = public_path().'/content/'.$catForDelete->icon;
                    File::delete($path);
                }
                DB::table('categories')->where('id',$catForDelete->id)->delete();
            }
        }
        return 0;
    }
}
