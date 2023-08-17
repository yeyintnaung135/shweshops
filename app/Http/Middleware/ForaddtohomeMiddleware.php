<?php

namespace App\Http\Middleware;

use App\Models\ForAddToHome;
use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ForaddtohomeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('web')->check()) {

            $hasthisuserrecord = ForAddToHome::where('user_id', Auth::guard('web')->user()->id);
            if ($hasthisuserrecord->count() == 0) {
                $createddata = ForAddToHome::create(['user_id' => Auth::guard('web')->user()->id, 'added' => 'no', 'show_atc' => 'yes']);

                Session::flash('show_add_to_home');

            } else {
                $added = $hasthisuserrecord->where('added', '=', 'yes');
                if ($added->count() == 0) {
                    if (Carbon::now()->subDays(2) > ForAddToHome::where('user_id', Auth::guard('web')->user()->id)->first()->created_at) {
                        Session::flash('show_add_to_home');
                        ForAddToHome::where([['user_id', '=', Auth::guard('web')->user()->id]])->update(['show_atc' => 'yes', 'created_at' => Carbon::now()]);

                    }
                }

            }
        }

        return $next($request);
    }
}
