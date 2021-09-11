<?php

namespace App\Http\Middleware;

use App\Models\Set;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class BelongsToUnitId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $set = Set::find($request->set);
        if ($request->id == 0)
            return $next($request);

        if ($set->fire_brigade_unit_id == Auth::user()->fire_brigade_unit_id || Auth::user()->privilege_id == 1)
            return $next($request);
        else
            return redirect('/');
    }
}
