<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Admin\Settings;
use Illuminate\Routing\Redirector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\Logger;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct(Request $request, Redirector $redirector)
    {
        $this->request = $request;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $logs = Logger::orderByDesc('id')->limit(7)->get();

        foreach($logs as $k => $l){
            $l->humanTime = 'asdasd';//Carbon::createFromFormat('Y-m-d H:i:s', $l->created_at)->diffForHumans(null, true);
        }

        $users =  DB::table('users')->count();
        // $services =  DB::table('services')->whereNull('deleted_at')->count();
        // $pending =  DB::table('users')->where('verify','pending')->count();
        $orders =  DB::table('orders')->where('status','approved')->count();

        // view()->share('services', $services);
        // view()->share('pending', $pending);
        view()->share('users', $users);
        view()->share('orders', $orders);

        view()->share('logs', $logs);
        view()->share('menu', 'dashboard');
        return view('admin.dashboard');
    }

    public function profile(){
        return view('admin.profile');
    }

    public function saveSettings(Request $request){
        $data = $request->all();

        // DB::table('settings')->where('key', 'rso_rate')->update(['value' => $data['rso_rate']]);
        // DB::table('settings')->where('key', 'rs_rate')->update(['value' => $data['rs_rate']]);

        return json_encode(array('status' => 1));
    }

    public function saveContact(Request $request){
        $data = $request->all();

        DB::table('settings')->where('key', 'contact_email')->update(['value' => $data['contact_email']]);
        DB::table('settings')->where('key', 'discord_link')->update(['value' => $data['discord_link']]);

        return json_encode(array('status' => 1));
    }
}
