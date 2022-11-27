<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class Localization
{
    public function handle(Request $request, Closure $next)
    {
        $locale = Auth::user() ? Auth::user()->language : 'en';
        
        if (! in_array($locale, ['en', 'ru', 'am'])) {
            abort(400);
        }
     
        App::setLocale($locale);
        return $next($request);
    }
}
