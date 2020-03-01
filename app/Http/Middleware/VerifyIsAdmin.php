<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class VerifyIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        if(!Auth::user()->isAdmin()){
            abort(401);
            #return redirect('/');
        }
        return $next($request);
    }
}
