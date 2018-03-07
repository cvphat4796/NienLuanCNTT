<?php

namespace App\Http\Middleware;

use Closure;

class SoGDMiddleware
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
        $user =  $request->user();
        if($user->pq_maso != $role){
            return redirect('bo-giao-duc');
        }
        return $next($request);
    }
}
