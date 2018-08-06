<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;

class AdminMiddleware
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
        $user_id = \Auth::id();

        if(roles($user_id) == 'admin')
        {
            // You are admin
            return $next($request);
        }
        else
        {
            Redirect::to('/')->send();
        }
    }
}
