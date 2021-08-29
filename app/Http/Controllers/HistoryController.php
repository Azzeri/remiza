<?php

namespace App\Http\Controllers;

use App\Models\History;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Cookie;

class HistoryController extends Controller
{
    public function index(Request $request, $id)
    {
        $history = History::where('user_id', $id)->get();
        // $cookies = Cookie::get();
        // dd($request->ip());
        return Inertia::render('loginHistory', ['history' => $history]);
    }

    public function store()
    {
        History::create(
            [
                'user_id' => Auth::user()->id
            ]
        );

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
