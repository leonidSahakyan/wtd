<?php

namespace App\Http\Controllers\Admin;

use App\Events\SendNotification;
use App\Http\Controllers\Controller;
use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MasterController extends Controller
{
    protected $request;

    public function __construct(Request $request, Redirector $redirector)
    {
        // $this->middleware(function ($request, $next) {
        //     if (!Helper::checkPermission(['superadmin'])) {
        //         return redirect(route('adminLogin'));
        //     }
        //     return $next($request);
        // });
    }

    public function index()
    {
        return view('admin.masters.index');
    }

    public function data(Request $request)
    {
        $model = new Admin();

        $filter = array('search' => $request->input('search'));    

        $items = $model->getAll(
            $request->input('start'),
            $request->input('length'),
            $filter,
            $request->input('sort_field'),
            $request->input('sort_dir')
        );

        $data = json_encode(array('data' => $items['data'], 'recordsFiltered' => $items['count'], 'recordsTotal'=> $items['count']));
        return $data;
    }

    public function get(Request $request)
    {
        $id = (int)$request->input('id');

        if($id){
            $item = Admin::find($id);

            if($item->avatar && $item->avatar != null){
                $item->avatar = asset('images/backendSmall/'.$item->avatar);
            }
            
            $mode = 'edit';
        }else{
            $item = new Admin();
            $item->id = 0;
            $mode = 'add';
        }
        $data = [
            'mode' => $mode,
            'item' => $item,
            'page' => false
        ];

        $template = view('admin.masters.item', $data)->render();
        
        $res = [
            'data' => $template,
            'status' => 1
        ];
        return response()->json($res);
    }

    public function save(Request $request)
    {
        $id = (int)$request->input('id');

        $validator = Validator::make($request->all(), [
            'name' => 'bail|required',
            'last_name' => 'bail|required',
            'email' => ['bail','required','email',Rule::unique('admin')->ignore($id)],
            'phone' => 'bail|required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'message' => $validator->getMessageBag()->first()
            ]);
        }
        $validated = $validator->validated();

        if(!$id){
            $password = Str::random(12);
            $item = new Admin();
            $item->name = $validated['name'];
            $item->last_name = $validated['last_name'];
            $item->email =  $validated['email'];
            $item->username = $validated['email'];
            $item->phone = $validated['phone'];
            $item->password = Hash::make($password);
            $item->role = 'master';
            $item->created_at = Carbon::now();
            $item->save();

            $data = [
                'email' => $validated['email'],
                'password' => $password,
                'notification_type' => 'AdminInvitation'
            ];
    
            event(new SendNotification($data));
        }else{
            $item = Admin::find($id);
            if(!$item) return json_encode(array('status' => 0, 'message' => "Can't save"));
            $item->name = $validated['name'];
            $item->last_name = $validated['last_name'];
            $item->email = $validated['email'];
            $item->username = $validated['email'];
            $item->phone = $validated['phone'];
            $item->save();
        }

        return response()->json(['status' => 1]);
    }

    public function remove()
    {
        $ids = $this->request->ids;

        DB::table('admins')->whereIn('id', $ids)->delete();

        return response()->json(['status' => 1]);
    }
}
