<?php

namespace App\Http\Middleware;

use Closure;

class CheckDemo
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
        abort_if($request->user()->demo, 403);
        return $next($request);
    }
}
