<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Admin\Settings;
use DB;

class DataComposer
{

    public function __construct()
    {
        
        // $settings = Settings::where('key','site_settings')->first();
        // $site_settings = json_decode($settings->value);
        // $this->site_settings = $site_settings;
        
        $cart = \Session::get('cart');
        $cartCount = 0;
        if(isset($cart['items'])){
            foreach($cart['items'] as $c){
                $cartCount += $c['qty'];
            }
        }
        $this->cartCount = $cartCount;
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('cartCount' , $this->cartCount);
        // $view->with('site_settings' , $this->site_settings);
       
    }
}