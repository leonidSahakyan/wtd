<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Twilio\Rest\Client;

class Sms extends Model
{
    use HasFactory;
    protected $table = 'sms';

    public static function send($phone,$message){
        return true;
        $sid = ENV('TWILIO_SID');
        $token = ENV('TWILIO_TOKEN');
        $twilio_phone = ENV('TWILIO_PHONE_NUMBER');

        $twilio = new Client($sid, $token);

        $phone = "+".$phone;
        $result = $twilio->messages ->create($phone,
                           array(
                            "from" => $twilio_phone, 
                            "body" => $message
                           ) 
                ); 
        return $result;
    }
}
