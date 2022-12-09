<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Admin\Settings;
use DB;

class DataComposer
{

    protected $discord_link;

    public function __construct()
    {
        $settings = Settings::where('key','site_settings')->first();
        $site_settings = json_decode($settings->value);
        $this->site_settings = $site_settings;
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('site_settings' , $this->site_settings);
       
    }
}