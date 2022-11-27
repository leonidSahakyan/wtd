<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Admin\Settings;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use file;



class SettingsController extends Controller
{
    public function settings(){
        $data = Settings::where('key','sait_settings')->first()->value;//find(2)->value;
        $data=json_decode($data);
        $price1        = Settings::where('key','price1')->first()->value;
        $price2        = Settings::where('key','price2')->first()->value;
        $min_days      = Settings::where('key','miniday')->first()->value;
        $min_order     = Settings::where('key','miniorder')->first()->value;
        $contact_email = Settings::where('key','contact_email')->first()->value;
        view()->share('menu', 'settings');
        return view('admin.settings',compact('data','price1','price2','min_days','min_order','contact_email'));
    }
    public function updateSettings(){
        $data=request()->validate([
            'email'=>'string',
            'phone'=>'string',
            'address'=>'string',
            'fax'=>'string',
            'facebook'=>'string',
            'twitter'=>'string',
        ]);
        $data1=Settings::where('key','sait_settings')->first();//find(2);
        $data1->update([
            "value"=>$data
        ]);
        return json_encode(array('status' => 1));
    }
    public function updateSettingsPrice(){
        $data=request()->validate([
            'inputPrice1'   => 'int',
            'inputPrice2'   => 'int',
            'min_days'      => 'int',
            'min_order'     => 'int',
            'contact_email' => 'string'
        ]);
        $dataPrice1        = Settings::where('key','price1')->first();
        $dataPrice2        = Settings::where('key','price2')->first();
        $dataminiday       = Settings::where('key','miniday')->first();
        $dataminiorder     = Settings::where('key','miniorder')->first();
        $dataContact_email = Settings::where('key','contact_email')->first();
        $dataPrice1->update([
            'value'=>$data['inputPrice1']
        ]);
        $dataPrice2->update([
            'value'=>$data['inputPrice2']
        ]);
        $dataminiday ->update([
             'value'=>$data['min_days']
        ]);
        $dataminiorder ->update([
            'value'=>$data['min_order']
       ]);
       $dataContact_email ->update([
        'value'=>$data['contact_email']
       ]);

        return json_encode(array('status' => 1));
    }
    public function updateimg(Request $request){
        $data=request()->validate([
            'image' => 'required|mimes:png|max:10000',
            'typeimg'=>'required' 
        ]);
        $image = $request ->file('image');
        $imgType = $image ->getClientmimeType();
        switch ($imgType) {
            case 'image/png':
                $ext = 'png';
                break;
            case 'image/jpg':
                $ext = 'jpg';
                break;
            default:
                $ext = 'jpeg';
                break;
        }
        switch ($data['typeimg']) {
            case  1:
                $filename = "logo";
                break;
            case 2:
                $filename = "contact";
                break;
        }
        $image_name= $filename.'.'.$ext;
        $destination_path = 'public/uploadimg';
        $path = $request->file('image')->storeAs($destination_path,$image_name);
        

        

        
        


    //     $filePath=$filename.'.'.$ext;
    //    if($image->save('signature/'.$filename.'.'.$ext,100)){
    //        return $filePath;
    //     }
    //     return false;
    }
}
