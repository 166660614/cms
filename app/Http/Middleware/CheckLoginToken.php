<?php

namespace App\Http\Middleware;

use Closure;

class CheckLoginToken
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
        if(!$request->session()->get('u_token')){
            echo "请先登录";
            header('refresh:2;url=/users/login');
            exit;
        }
        return $next($request);
    }
}
