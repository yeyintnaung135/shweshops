<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class GuestSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('super_admin')->check() and !Auth::guard('shop_owners_and_staffs')->check()) {


            if (!Session::has('guest_id')) {

                $randomnumber = rand(1000, 999999);

                Session::put('guest_id', $randomnumber);
            }
        }


        return $next($request);
    }
}
