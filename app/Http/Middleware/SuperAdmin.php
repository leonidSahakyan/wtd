<?php
namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class SuperAdmin
{

    public function handle($request, Closure $next)
    {
        if(Auth::guard('admin')->user()->role != 'superadmin'){
            return redirect(route('adminOrder'));    
        }
        return $next($request);
    }
}