<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Trait\ForSiteSetting;
use Closure;

class Chatison
{
    use ForSiteSetting;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($this->is_chat_on()){
            return $next($request);
        }else{
             abort(404);
        }
    }
}
