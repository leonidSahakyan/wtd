<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Settings;

class SettingsController extends Controller
{
    public function settings(){
        $data = Settings::where('key','site_settings')->first()->value;
        $data = json_decode($data);
        view()->share('menu', 'settings');
        return view('admin.settings',compact('data'));
    }
    public function updateSettings(){
        $data = request()->validate([
            'email'=>'string',
            'phone'=>'string',
            'address'=>'string',
            'facebook'=>'string',
            'instagram'=>'string',
        ]);
        $obj=Settings::where('key','site_settings')->first();
        $obj->update(["value"=>$data]);
        return json_encode(array('status' => 1));
    }
}
