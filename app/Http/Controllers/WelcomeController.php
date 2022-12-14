<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Meta;
use App\Models\Product;

class WelcomeController extends Controller
{
    public function __construct(Request $request){
        $this->request = $request;
	}
    
    public function shop($id){
        $id = $id ? (int)$id['id'] : false; 

		$query = DB::table('product');
        $query->select('product.id','title','slug','price','description','images.filename as file_name','images.ext as ext');
            
        if($id){
            $query->where('product.parent_id',$id);
        }
        $query->where('status',1)->where('featured',1)->whereNull('product.deleted_at');
        $query->join('images', 'images.id', '=', 'product.image_id');
        $feed = $query->orderBy('id', 'DESC')->paginate(9);

        view()->share('id', $id);
        view()->share('feed', $feed);

        if($this->request->ajax()){
            $listType = $this->request->t;
			return view('app.product-list-item-ajax',['type' => $listType]);
		}

        $collections = DB::table('collections')->select('id','title', 'slug')->whereNull('deleted_at')->where('status',1)->orderBy('ordering', 'DESC')->get();
        foreach($collections as $col){
            $items_count = DB::table('product')->whereNull('deleted_at')->where('status',1)->where('parent_id',$col->id)->count();
            $col->items_count = $items_count;   
        }

        $metaModel = new Meta();
        $collectionId = false;
        if($id){
            $collectionId = $id['id'];
            $meta = $metaModel->getMetaCollection($collectionId);
        }else{
            $meta = $metaModel->getMeta('shop');
        }
		view()->share('collectionId', $collectionId);
		view()->share('meta', $meta);

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
            'collections.slug as slug',
            'collections.image_id','images.filename as file_name','images.ext as ext',
        )
        ->where('collections.status', 1)
        ->where('collections.featured', 1)
        ->join('images', 'images.id', '=', 'collections.image_id')
        ->orderBy('collections.ordering', 'DESC')->limit(9)->get();

        $products = DB::table('product')
        ->select('product.id','title','slug','price','images.filename as file_name','images.ext as ext')
        ->where('status',1)->where('featured',1)->whereNull('product.temp')
        ->join('images', 'images.id', '=', 'product.image_id')->inRandomOrder()->limit(20)->get();

        $metaModel = new Meta();
		$meta = $metaModel->getMeta('home');

		view()->share('meta', $meta);
        view()->share('menu', 'home');
        view()->share('products', $products);
        view()->share('collections', $collections);
        return view('app.welcome');

    }
    public function product($id){
        $id = $id ? (int)$id['id'] : false; 
        $product = DB::table('product')->where('id',$id)->where('status',1)->whereNull('deleted_at')->first();
        $collection = DB::table('collections')->where('id',$product->parent_id)->first();
        $product->sizes = json_decode($product->sizes) ? json_decode($product->sizes) : []; 
        $product->colors = json_decode($product->colors) ? json_decode($product->colors) : [];
        
        $images = DB::table('images')->select('images.filename','images.ext','images.color')
        ->leftJoin('galleries','galleries.id','=','images.parent_id')
        ->where('galleries.id',$product->gallery_id)
        ->orderBy('images.ordering','asc')->get();
        
        $defaultColor = false;
        $imagesArray = []; 
        if(count($images) > 0){
            $defaultColor = $images[0]->color ? $images[0]->color : false;
            foreach($images as $image){
                $imagesArray[] = ['color'=>$image->color, 
                                'img_path' => asset('images/productItem/'.$image->filename.'.'.$image->ext.''),
                                'img_thumb' => asset('images/productThumb/'.$image->filename.'.'.$image->ext.'')
                                ];
            }
        }
        // $imagesJson = json_decode($imagesArray) ? json_decode($imagesArray) : [];
        view()->share('menu', false);
        
        $related = DB::table('product')->select('title','price','slug','images.filename as file_name','images.ext as ext')
        ->where('product.parent_id',$product->parent_id)->where('product.id','!=',$id)->where('status',1)->whereNull('deleted_at')
        ->leftJoin('images','images.id','=','product.image_id')->inRandomOrder()->limit(7)->get();

        $metaModel = new Meta();
		$meta = $metaModel->getMetaProduct($id);
		view()->share('meta', $meta);
		view()->share('related', $related);

        return view('app.product',compact('product','collection','imagesArray','defaultColor'));
    }

    public function cart(){
        $cart = \Session::get('cart');

        if(!$cart){
            return redirect()->route('homepage');
        }
        $products = array();
        
        $subTotal = 0;
        $itemsCount = 0;
        $productModel = new Product();
        foreach($cart['items'] as $cartItem){
            //:TODO if no item
            $product = $productModel->getProductWithImage($cartItem['id'],isset($cartItem['color']) ? $cartItem['color']: false);
            if($product->filename){
                $product->imagePath = asset('images/productList/'.$product->filename.'.'.$product->ext.''); 
            }else{
                $product->imagePath = asset('asset/img/product-detail-1.jpg'); 
            }
            $product->cart_data = $cartItem;
            $products[] = $product;
            $subTotal += $product->price * $cartItem['qty'];
            $itemsCount += $cartItem['qty'];
        }


        $countries = DB::table('countries')->select('*')->where('status',1)->orderBy('title','ASC')->get();
        view()->share('itemsCount', $itemsCount);
        view()->share('countries', $countries);
        view()->share('subTotal', $subTotal);
        view()->share('products', $products);
        view()->share('menu', false);
        return view('app.cart');
    }

    public function updateCart(Request $request){
        $validator = Validator::make($request->all(),[
            'id' => 'required|int',
            'qty' => 'required|int',
            'color' => 'nullable|string',
            'size' => 'nullable|string'
        ]);
        $newQty = $request->newQty;
        $itemData = json_decode($request->itemData);
        if(!(int)$itemData->id){
            return response()->json(['error' => 'Wrong id'], 422);
        }
        $cart = \Session::get('cart');
        
        $exists = -1;
        foreach($cart['items'] as $key => $value){
            if(isset($itemData->size) && isset($itemData->color)){
                if($value['id'] == $itemData->id && $value['size'] == $itemData->size && $value['color'] == $itemData->color){
                    $exists = $key;
                    break;
                }
            }
            if(isset($itemData->size) && !isset($itemData->color)){
                if($value['id'] == $itemData->id && $value['size'] == $itemData->size){
                    $exists = $key;
                    break;
                }
            }
            if(!isset($itemData->size) && isset($itemData->color)){
                if($value['id'] == $itemData->id && $value['color'] ==$itemData->color){
                    $exists = $key;
                    break;
                }
            }
            if(!isset($itemData->size) && !isset($itemData->color)){
                if($value['id'] == $itemData->id){
                    $exists = $key;
                    break;
                }
            }
        }
        if($exists == '-1'){
            return response()->json(['error' => 'Cant find item in cart'], 422);
        }else{
            $cart['items'][$exists]['qty'] = $newQty;
        }

        \Session::put('cart', $cart);

        $cartCount = 0;
        foreach($cart['items'] as $c){
            $cartCount += $c['qty'];
        }
        return json_encode(array('status' => 1,'cart_count' => $cartCount));
    }
    
    public function removeCart(Request $request){
        $validator = Validator::make($request->all(),[
            'id' => 'required|int',
            'qty' => 'required|int',
            'color' => 'nullable|string',
            'size' => 'nullable|string'
        ]);
        $itemData = json_decode($request->itemData);
        if(!(int)$itemData->id){
            return response()->json(['error' => 'Wrong id'], 422);
        }
        $cart = \Session::get('cart');
        
        $exists = -1;
        foreach($cart['items'] as $key => $value){
            if(isset($itemData->size) && isset($itemData->color)){
                if($value['id'] == $itemData->id && $value['size'] == $itemData->size && $value['color'] == $itemData->color){
                    $exists = $key;
                    break;
                }
            }
            if(isset($itemData->size) && !isset($itemData->color)){
                if($value['id'] == $itemData->id && $value['size'] == $itemData->size){
                    $exists = $key;
                    break;
                }
            }
            if(!isset($itemData->size) && isset($itemData->color)){
                if($value['id'] == $itemData->id && $value['color'] ==$itemData->color){
                    $exists = $key;
                    break;
                }
            }
            if(!isset($itemData->size) && !isset($itemData->color)){
                if($value['id'] == $itemData->id){
                    $exists = $key;
                    break;
                }
            }
        }
        if($exists == '-1'){
            return response()->json(['error' => 'Cant find item in cart'], 422);
        }else{
            unset($cart['items'][$exists]);
        }

        if(count($cart['items']) < 1){
            \Session::forget('cart');
            return json_encode(array('status' => 1,'cart_count' => 0));
        }

        \Session::put('cart', $cart);

        $cartCount = 0;
        foreach($cart['items'] as $c){
            $cartCount += $c['qty'];
        }
        return json_encode(array('status' => 1,'cart_count' => $cartCount));
    }
    public function addToCart(Request $request){
        $validator = Validator::make($request->all(),[
            'id' => 'required|int',
            'qty' => 'required|int',
            'color' => 'nullable|string',
            'size' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        // $request->session()->forget('cart');
        $id = (int)$request->id;
        $qty = (int)$request->qty;
        $color = $request->color;
        $size = $request->size;
        $product = DB::table('product')->select('*')->whereNull('deleted_at')->where('status', 1)->where('id',$id)->first();

        if(!$product){
            return response()->json(['errors' => ["server"=>"something wrong"]], 422);
        }

        $product->sizes = json_decode($product->sizes) ? json_decode($product->sizes) : [];
        if((count($product->sizes) && !$size) || (count($product->sizes) && !in_array($size,$product->sizes)) ){
            return response()->json(['errors' => ['size' => "Size is requierd"]], 422);    
        }
        $product->colors = json_decode($product->colors) ? json_decode($product->colors) : [];
        if((count($product->colors) && !$color) || (count($product->colors) && !in_array($color,$product->colors)) ){
            return response()->json(['errors' => ['size' => "Color is requierd"]], 422);    
        }
        if($qty < 1){
            return response()->json(['errors' => ['qty' => "Qty is requierd"]], 422);
        }

        $item = ['id' => $id, 'qty' => $qty];
        if(count($product->sizes ) > 0){
            $item['size'] = $size;
        }
        if(count($product->colors ) > 0){
            $item['color'] = $color;
        }

        // $cart = session('cart');
        $cart = \Session::get('cart');
        if(!isset($cart['items'])){
            $cart['items'] = [];
            $cart['items'][] = $item;
        }else{
            $exists = -1;
            foreach($cart['items'] as $key => $value){
                if(count($product->sizes ) && !isset($value['size'])){
                    unset($cart['items'][$key]);
                    break;
                }
                if(count($product->colors ) && !isset($value['color'])){
                    unset($cart['items'][$key]);
                    break;
                }
                if(count($product->sizes )&& count($product->colors)){
                    if($value['id'] == $id && $value['size'] == $size && $value['color'] == $color){
                        $exists = $key;
                        break;
                    }
                }
                if(count($product->sizes ) && !count($product->colors )){
                    if($value['id'] == $id && $value['size'] == $size){
                        $exists = $key;
                        break;
                    }
                }
                if(count($product->colors ) && !count($product->sizes )){
                    if($value['id'] == $id && $value['color'] == $color){
                        $exists = $key;
                        break;
                    }
                }
                if(!count($product->colors ) && !count($product->sizes )){
                    if($value['id'] == $id){
                        $exists = $key;
                        break;
                    }
                }
            }
            if($exists != '-1'){
                $cart['items'][$exists]['qty'] = $cart['items'][$exists]['qty'] + $qty; 
            }else{
                $cart['items'][] = $item;
            }
        }

        \Session::put('cart', $cart);
        $cartCount = 0;
        foreach($cart['items'] as $c){
            $cartCount += $c['qty'];
        }
        return json_encode(array('status' => 1,'cart_count' => $cartCount));
    }
}
