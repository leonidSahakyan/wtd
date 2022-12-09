<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Doc;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use PDF;
use Mail;
use Session;

class WelcomeController extends Controller
{
    public function __construct(Request $request){
		$this->request = $request;
	}

    public function shop($id){
        // Feed Start
		$query = DB::table('product');
        $query->select('product.id','title','slug','price','description','images.filename as file_name','images.ext as ext');
        if($id){
            $query->where('product.parent_id',$id);
        }
        $query->where('status',1)->where('featured',1)->whereNull('product.deleted_at');
        $query->join('images', 'images.id', '=', 'product.image_id');
        $feed = $query->orderBy('id', 'DESC')->paginate(1);

        view()->share('feed', $feed);

        if($this->request->ajax()){
            $listType = $this->request->t;
			return view('app.product-list-item-ajax',['type' => $listType]);
		}

        $collections = DB::table('collections')
        ->select('collections.title as title', 'collections.slug as slug',DB::raw('count(*) as items_count'))
        ->join('product', 'product.parent_id', '=', 'collections.id')->whereNull('collections.deleted_at')
        ->where('collections.status', 1)
        ->orderBy('collections.ordering', 'DESC')->groupBy('collections.title','collections.slug')->get();


        view()->share('collections', $collections);
        view()->share('menu', 'shop');
        return view('app.shop');
    }
    public function homepage()
    {
        $collections = DB::table('collections')
        ->select(
            'collections.title_droped as title',
            'collections.created_at as created',
            'collections.image_id','images.filename as file_name','images.ext as ext',
        )
        ->where('collections.status', 1)
        ->where('collections.featured', 1)
        ->join('images', 'images.id', '=', 'collections.image_id')
        ->orderBy('collections.ordering', 'DESC')->limit(9)->get();

        $products = DB::table('product')
        ->select('product.id','title','slug','price','images.filename as file_name','images.ext as ext')
        ->where('status',1)->where('featured',1)
        ->join('images', 'images.id', '=', 'product.image_id')->inRandomOrder()->limit(20)->get();

        view()->share('menu', 'home');
        view()->share('products', $products);
        view()->share('collections', $collections);
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

    public function addToCart(Request $request){
        $validator = Validator::make($request->all(),[
            'id' => 'required|int'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // $request->session()->forget('cart');
        $id = (int)$request->id;
        $item = ['id' => $id, 'qty' => 1];

        $qty = 1;
        $cart = session('cart');
        if(!isset($cart['items'])){
            $cart['items'] = [];
            $cart['items'][] = $item;
        }else{
            $exists = -1;
            foreach($cart['items'] as $key => $value){
                if($value['id'] == $id){
                    $exists = $key;
                    break;
                }
            }
            if($exists != '-1'){
                $cart['items'][$exists]['qty'] = $cart['items'][$exists]['qty'] + $qty; 
            }else{
                $cart['items'][] = $item;
            }
        }

        $request->session()->put('cart', $cart);
        $asd = session('cart');
        var_dump($asd);
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
