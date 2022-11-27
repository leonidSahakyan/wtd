<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Sms;
// use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'company',
        'phone',
        'email',
        'licanece_number',
        'logo',
        'email',
        'address',
        'password',
       
    ];
   
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at','updated_at','status','expo_token'
    ];

    
    public static function sendVerificationCode($phone){
        
        $now = date("Y-m-d H:i:s");
        $exp_date = date('Y-m-d H:i:s',strtotime('+1 minutes',strtotime($now)));
        
        $code = rand(100000, 999999);
        // $code = 420069;
        $message = "Your activation code is: ".$code;
        
        if(Sms::send($phone,$message)){
            $insert = DB::table('code')->insert([
                'phone' => $phone,
                'code' => $code,
                'exp_date' => $exp_date
            ]);
            return $insert ? $exp_date : false; 
        }
        return false;
    }

    public static function validateCode($phone,$code){
        $now = date("Y-m-d H:i:s");
        $checkActiveCode = DB::table('code')->select('id')->where('phone', $phone)->where('code',$code)->where('exp_date','>',$now)->where('used',0)->first();
        return $checkActiveCode ? $checkActiveCode->id : false;
    }

    public static function checkExistingActivation($phone){
        $now = date("Y-m-d H:i:s");
        $checkExistingCode = DB::table('code')->where('phone', $phone)->where('used',0)->where('exp_date','>',$now)->first();
        return $checkExistingCode ? true : false;
    }

    public static function getEmployers($category_id,$page){
        $user = auth()->user();
        
        $lat  = $user->lat; //"23.139422"; //$user->lat;  //your current lat
        $lon =  $user->lon; //"-82.382617"; //$user->lon; your current long
        $query = DB::table('services');
        
        $coordinatesFilter = ($lat && $lon) ? true : false; 
        if($coordinatesFilter){
            $query->select(array("services.id as id","services.category_id as category_id","services.price as price","users.id as user_id","users.fullname as fullname","users.rating as rating","users.avatar as avatar","users.verify as verify",
                            DB::raw("( 3959 * acos( cos( radians( ".$lat." ) ) * cos( radians( lat ) ) * cos( radians( lon ) - radians( ".$lon." ) ) 
                                    + sin( radians( ".$lat." )) * sin( radians( lat ) ) ) ) AS distance")));    
        }else{
            $query->select("services.id as id","services.category_id as category_id","services.price as price","users.id as user_id","users.fullname as fullname","users.rating as rating","users.avatar as avatar","users.verify as verify");
        }
        $query->leftJoin('users', 'users.id', '=', 'services.user_id');
        $query->where('services.category_id',$category_id);
        $query->where('users.id','!=',$user->id);
        $query->where('users.status','active');
        $query->whereNull('services.deleted_at');
        $query->orderBy("users.rating", "desc");
        if($coordinatesFilter){
            $query->orderBy("distance", "ASC");
        }
        $length = 4;
        $start = $page == 1 ? 0 : ($page - 1)  * $length;
        $query->skip($start)->take($length);
        $employers = $query->get();

        foreach($employers as $employee){
            if($employee->verify == 'pending'){
                $employee->verify = 'base';    
            }
            $images =  DB::table('images')->select('id','filename')->where('parent_id', $employee->id)->get();
            $imagesArray = [];
            foreach($images as $image){
                $imagesArray[] = array('id'=>$image->id,'thumb_url'=>asset('images/galleryList/'.$image->filename),'image_url'=>asset('images/original/'.$image->filename));
            }
            if($employee->avatar && $employee->avatar != null){
                $employee->avatar = asset('images/avatar/'.$employee->avatar);
            }
            $employee->images = $imagesArray; 
        }
        return $employers;
    }

    public static function getEmployee($id,$customer_id){
        $employee = DB::table('users')->select('id','fullname','about','rating','avatar','verify')->where('id',$id)->first();
        $services = DB::table('services')->select('id','category_id','user_id','price')->where('user_id',$id)->where('deleted_at',null)->get();

        $reviews = DB::table('orders')->select('services.category_id','orders.rate','orders.created_at','orders.comment','users.fullname as fullname')
                                        ->leftJoin('services', 'services.id', '=', 'orders.service_id')
                                        ->leftJoin('users', 'users.id', '=', 'orders.user_id')
                                        ->whereNotNull('orders.rate')
                                        ->where('users.status','active')
                                        ->where('orders.employee_id',$id)->where('orders.status','approved')->get();
                                        
        $isBooked = DB::table('bookmarks')->select('id')->where('employee_id',$id)->where('user_id',$customer_id)->first();
        $isBooked = $isBooked ? true : false;
        if($employee->verify == 'pending'){
            $employee->verify = 'base';    
        }
        if($services){
            foreach($services as $service){
                $images =  DB::table('images')->select('id','filename')->where('parent_id', $service->id)->get();
                $imagesArray = [];
                foreach($images as $image){
                    $imagesArray[] = array('id'=>$image->id,'thumb_url'=>asset('images/galleryList/'.$image->filename),'image_url'=>asset('images/original/'.$image->filename));
                }
                $service->images = $imagesArray; 
            }
        }
        
        if($reviews){
            foreach($reviews as $review){
                $review->created_at = strftime("%d %b %Y", strtotime($review->created_at));
            }
        }
        if($employee->avatar && $employee->avatar != null){
            $employee->avatar = asset('images/avatar/'.$employee->avatar);
        }
        $employee->services = $services;
        $employee->reviews = $reviews;
        $employee->is_booked = $isBooked;
        return $employee;
    }
}
