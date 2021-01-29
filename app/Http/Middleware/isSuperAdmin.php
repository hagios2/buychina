<?php

namespace App\Http\Middleware;

use Closure;

class isSuperAdmin
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
        if(auth()->guard('admin')->check())
        {
            if(auth()->guard('admin')->user()->role == 'super_admin')
            {
                return $next($request);
            
            }else{

                return response()->json(['message' => 'Forbidden']);
            }
        }else{

            return response()->json(['message' => 'Unauthenticated']);
        }
        
    }
}
return response()->json(['message' => 'Forbidden']);  return response()->json(['message' => 'Forbidden']);  return response()->json(['message' => 'Forbidden']);