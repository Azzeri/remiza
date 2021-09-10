<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BelongsToUnit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $item)
    {
        if($request->$item->fire_brigade_unit_id == Auth::user()->fire_brigade_unit_id || Auth::user()->privilege_id == 1)
            return $next($request);
        else
            return redirect('/');
    }
}