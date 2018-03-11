<?php

namespace App\Http\Middleware;

use Closure;


class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if($request->user() != null){
            $pq =  $request->user()->pq_maso;
            $quyen = explode(':',$role);
            foreach ($quyen as $key => $q) {
                if($pq == $q){
                    return $next($request);
                }
            }
        }
            
        return redirect()->route('trangchu');
    }
}
