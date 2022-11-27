<?php

namespace App\Http\Controllers;

use Validator;
use Session;
use App\Models\User;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function ordersPprofile(Request $request){
        return view('app.orders-profile');
    }

    public function personaIinfo(){

        return view('app.auth');
    }
    public function  orderData(Request $request){
        $model = new Order();

        $filter = array(
            'status' => $request->input('filter_status'),
            'category' => $request->input('filter_category'),
        );

        $items = $model->getAll(
            $request->input('start'),
            $request->input('length'),
            $filter,
            $request->input('sort_field'),
            $request->input('sort_dir'),
        );

        $data = json_encode(array('data' => $items['data'], 'recordsFiltered' => $items['count'], 'recordsTotal'=> $items['count']));
        return $data;
    }
    public function orderGet(Request $request){
 
        $id = (int)$request['id'];
        if($id){
            $item = Order::find($id);
            $mode = 'edit';
        }
        $data = json_encode(
            array('data' =>
                (String) view('app.orders-item-profile', array(
                    'item'=>$item,
                    'mode' => $mode,
                )),
                'status' => 1)
            );

        return $data;
    }

    public function signup(Request $request)
    {
        $request->validate([
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'company'         => 'required|string|max:255',
            'phone'           => 'required|numeric',
            'address'         => 'required',
            'licanece_number' => 'required|numeric',
            'email'           => ['required',Rule::unique('users')->ignore($request->id)],
            'password'        => 'required|min:6',
        ]);
        Auth::login($user = User::create([
            
            'first_name'        => $request->first_name,
            'last_name'         => $request->last_name,
            'company'           => $request->company,
            'phone'             => $request->phone,
            'address'           => $request->address,
            'licanece_number'   => $request->licanece_number,
            'email'             => $request->email,
            'password'          => Hash::make($request->password),

        ]));

        return json_encode(array('status' => 1, 'redirect' => route('homepage')));
    }

    public function logout(Request $request)
    {
       
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('user-auth');
    }

    public function signin(LoginRequest $request){
       
        
        $request->authenticate();
        $request->session()->regenerate();

        return json_encode(array('status' => 1, 'redirect' => route('homepage')));
    }

    public function saveProfile(Request $request)
    {
      
        $request->validate([
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'company'         => 'required|string|max:255',
            'phone'           => 'required|numeric',
            'address'         => 'required',
            'licanece_number' => 'required|numeric',
            'email'           => ['required','string',Rule::unique('users')->ignore(Auth::guard('web')->user()->id),        
            ],
        ]);
        
        $data = array();
        $data['first_name']      = $request['first_name'];
        $data['last_name']       = $request['last_name'];
        $data['email']           = $request['email'];
        $data['phone']           = $request['phone'];
        $data['address']         = $request['address'];
        $data['company']         = $request['company'];
        $data['licanece_number'] = $request['licanece_number'];

        if(User::where('id', Auth::guard('web')->user()->id)->update($data)){
            Session::flash('success', 'save successfully!');
            return back();
        }
        return json_encode(array('status' => 0, 'message' => 'Something wrong, please try later!'));
    }
    public function profilePassword()
    {
        return view('app.change-password');

    }
    public function changePassword(Request $request)
    {
        $request_data = $request->validate([
            'old_password'     => 'required|min:6',
            'new_password'     => 'required|min:6',
            'confirm_password' => 'required|min:6|same:new_password'
        ]);

        $current_password = Auth::user()->password;
        if (Hash::check($request_data['old_password'], $current_password)) {
            $user_id = Auth::id();
            $obj_user = User::find($user_id);
            $obj_user->password = Hash::make($request_data['confirm_password']);
            $obj_user->save();
            return redirect()->back()->withSuccess('Password cahnge successfully!');
        } else {
            return redirect()->back()->with('error', 'Old Password invalid');
        }
    }
      public function sendPasswordRecover(request $request)
    {
        $data['email'] = $request->input('recoverEmail');

        $data = array_intersect_key($data, self::$passwordRecoverValidation);
        // Run validations
        $validation = Validator::make($data, self::$passwordRecoverValidation);

        // Return Error if validation fails
        if ($validation->fails()) {
            return response()->json(['errors' => trans('app.wrong_email_format')], 401);
        }

        $user = User::where('email', '=', $data['email'])->first();
        if (!$user) return response()->json(['status' => 0, 'message' => trans('app.email_doesnt_exist')], 200);

        $pw = bcrypt(str_random(35));

        $user->recovery_hash = $pw;
        $user->recovery_exp = Carbon::now()->addHour()->toDateTimeString();
        $user->save();

        $data['pw'] = $pw;
        $data['name'] = $user->name;
        $data['surname'] = $user->surname;

        $mail = Mail::send('emails.recovery', $data, function ($message) use ($data) {
            $message->from('no-reply@brainee.me', "Brainee.me");
            $message->subject("Password recovery");
            $message->to($data['email']);

        });

        return response()->json(['message' => trans('app.recovery_check_email'), 'status' => 1], 200);
    }
    public function checkRecoveryHash(request $request)
    {
        $recovery_hash = $request->input('recoveryHash');
        $user = User::where('recovery_hash', '=', $recovery_hash)->first();

        if (!$user) {
            return response()->json(['status' => 0, 'message' => trans('app.wrong_recovery_hash')], 400);
        } else {

            if ($user->recovery_exp < Carbon::now()->toDateTimeString()) {
                return response()->json(['status' => 0, 'message' => trans('app.recovery_hash_exp_error')], 400);
            } else {
                return response()->json(['status' => 1, 'message' => trans('app.correct_hash')], 200);
            }
        }
    }

    // Recovery password

    protected static $recoverPasswordValidation = array(
        'recoveryPassword'   => 'required|min:6',
        'recoveryPasswordRe' => 'same:recoveryPassword',
        'recoveryHash'       => 'required',
    );

    public function recoveryPassword(request $request)
    {
        $data['recoveryPassword'] = $request->input('recoveryPassword');
        $data['recoveryPasswordRe'] = $request->input('recoveryPasswordRe');
        $data['recoveryHash'] = $request->input('recoveryHash');

        $data = array_intersect_key($data, self::$recoverPasswordValidation);

        $messages = [
            'same' => trans('app.password_not_matched'),
        ];

        // Run validations
        $validation = Validator::make($data, self::$recoverPasswordValidation, $messages);

        $errors = array();
        // Return Error if validation fails
        if ($validation->fails()) {
            return response()->json(['status' => 0, 'error' => $validation->errors()->first()], 400);
        }

        $user = User::where('recovery_hash', '=', $data['recoveryHash'])->first();
        if (!$user) {
            return response()->json(['error' => trans('app.wrong_recovery_hash')], 400);
        }

        if ($user->recovery_exp < Carbon::now()->toDateTimeString()) {
            return response()->json(['status' => 0, 'errors' => trans('app.recovery_hash_exp_error')], 400);
        }

        if ($user) {
            $user->fill([
                'password' => bcrypt($data['recoveryPassword']),
                'recovery_hash' => null,
                'recovery_exp' => null,
            ])->save();

            return response()->json(['status' => 1, 'message' => trans('app.success_password_saved')], 200);
        } else {
            return response()->json(['status' => 0, 'errors' => trans('app.error_password_saved')], 400);
        }
    }
        

}