<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(\Auth::user()){
            if(\Auth::user()->type !== 'admin'){
                return response()->json('You are not allowed to access this page !');
            }
        }else{
            return redirect()->route('login');
        }
        return $next($request);
    }
}
