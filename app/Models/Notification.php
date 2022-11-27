<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\App;

class Notification extends Model
{
    use HasFactory;
    public static function send($user_id,$title,$body,$type,$order_id,$notificationData,$transform = false){
        //type // order_request,order_approved,order_declined,order_canceled
        if($transform){
            $user = DB::table('users')->select('expo_token','language')->where('id', $user_id)->first();
            App::setLocale($user->language);
            $title = trans($title);
            $body = trans($body);
        }else{
            $user = DB::table('users')->select('expo_token')->where('id', $user_id)->first();
        }
        $data = array('user_id' => $user_id,'title' => $title,'body' => $body,'type' => $type,'order_id' => $order_id,'created_at' => date("Y-m-d H:i:s"),'data'=> serialize($notificationData));
        
        if(!$user || $user->expo_token == null || $user->expo_token == ''){
            Log::critical("Can't get user Token for push notification: UserId -".$user_id);
            $data["status"] = 0;
            DB::table('notification')->insert($data);
            return;
        }


        $response = Http::post('https://exp.host/--/api/v2/push/send', [
            'to' => $user->expo_token,
            'title' => $title,
            'body' => $body,
            "sound" => "default",
            'data' => $notificationData,
        ]);

        $data["status"] = 1;
        DB::table('notification')->insert($data);
    }
}
