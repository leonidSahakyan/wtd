<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Gallery;
use App\Models\Service;
use App\Models\Requests;
use App\Models\Doc;
use App\Models\Admin\slider;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use PDF;
use Mail;

class WelcomeController extends Controller
{
    public function homepage()
    {
        $faq    =  DB::table('faq')->where('published',1)->get();
        $slider = DB::table('slider')
        ->select(
            'slider.title as title',
            'slider.description as description',
            'slider.linktype',
            'published','namebutton','link',
            'slider.image_id',
            'images.filename as image_file_name',
        )
        ->where('slider.published', 1)
        ->leftJoin('images', 'images.id', '=', 'slider.image_id')
        ->orderBy('published', 'DESC')->get();

        $services = DB::table('services')
        ->select(
            'services.title as title',
            'services.description as description',
            'services.body as body',
            'published','featured',
            'services.image_id',
            'images.filename as image_file_name',
        )
        ->where('services.published', 1)
        ->where('services.featured', 1)
        ->leftJoin('images', 'images.id', '=', 'services.image_id')
        ->orderBy('published', 'DESC')->inRandomOrder()->limit(3)->get();

        view()->share('menu', 'home');
        view()->share('faq', $faq);
        view()->share('slider', $slider);
        view()->share('services', $services);
       
        
        return view('app.welcome');
    }
    public function services(){
        $services = DB::table('services')
        ->select(
            'services.title as title',
            'services.description as description',
            'services.body as body',
            'published','featured',
            'services.image_id',
            'images.filename as image_file_name',
        )
        ->where('services.published', 1)
        ->leftJoin('images', 'images.id', '=', 'services.image_id')
        ->orderBy('published', 'DESC')->get();
        return view('app.services',compact('services'));
    }
    public function requestQuote()
    {
        $gallery = new Gallery();
        $gallery->save();

        view()->share('galleryId', $gallery->id);
        return view('app.request_quote');
    }
   
    public function requestQuoteSubmit(Request $request){
        $validator = Validator::make($request->all(),[
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'email'      => 'required|string|email|max:50',
            'phone'      => 'required|string|max:50',
            'comment'      => 'nullable|string|max:500',
            'gallery_id'=> 'required|int',
            'el_bill'      => 'nullable|int'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $item = new Requests();

        if((int)$request->el_bill){
            $item->image_id = $request->el_bill;
        }

        $gallery = Gallery::find($request->gallery_id);
        $gallery->temp = 0;
        $gallery->save();
        $item->gallery_id = $request->gallery_id;

        $item->first_name = $request->first_name;
        $item->last_name  = $request->last_name;
        $item->comment  = $request->comment;
        $item->email      = $request->email;
        $item->phone      = $request->phone;
        $item->created_at = date("Y-m-d H:i:s");
        $item->save();
        return json_encode(array('status' => 1));
    }
    public function contact()
    {
        view()->share('menu', 'contact');
        return view('app.contact');
    }
    public function auth()
    {
        view()->share('menu', 'signin');
        return view('app.auth');
    }
    public function sign()
    {
        view()->share('menu', 'signin');
        return view('app.sign');
    }
    public function send(Request $request)
    {
        // dd($request->all());

        $validated = $request->validate([
            'email' => 'email:rfc', //,dns
            'name' => 'string',
            'subject' => 'string',
            'phone' => 'numeric',
            'message' => 'required|string'
        ]);

        $data = DB::table('settings')->whereIn('key', ['contact_email'])->get()->keyBy('key');
        $contact_email = $data['contact_email']->value;
        $data = array();
        $data['email'] = $request['email'];
        $data['name'] = isset($request['name']) ? $request['name'] : '-----';
        $data['subject'] = isset($request['subject']) ? $request['subject'] : '-----';
        $data['msg'] = $request['message'];
        $data['phone'] = $request['phone'];

        $mail = Mail::send('emails.contact', $data, function ($message) use ($contact_email) {
            $message->from('no-reply@solar.solar', "Solar");
            $message->subject("Solar contact");
            $message->to($contact_email);
        });


        return json_encode(array('status' => 1));
    }
    public function signImg () {
        $data = request()->validate(['savePngData'=>'string']);
        $base64_image= $data['savePngData'];
        $image = Image::make($base64_image);
        $model = new Doc();
        $imageUrl = $model->addBase64Image($image);

        return response()->json(['success' => array('signPath'=>$imageUrl,'status'=>1)]);
    }
    public function ForPdf(){
        $data = request()->validate(['pdfSign'=>'string']);
        $path = 'signature/' . $data['pdfSign'];
        $pdf = PDF::loadHTML("<img src='$path'>
           ");
        return $pdf->stream();
    }

}
