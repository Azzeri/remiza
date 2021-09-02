<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Cookie;
use Jenssegers\Agent\Agent;

class HistoryController extends Controller
{
    public function index(Request $request, $id)
    {
        $history = History::where('user_id', $id)->paginate(4);
        return Inertia::render('loginHistory', ['history' => $history]);
    }

    public function storeSuccess(Request $request)
    {
        $agent = new Agent();

        History::create(
            [
                'user_id' => Auth::user()->id,
                'success' => true,
                'ip' => $request->ip(),
                'browser' => $agent->browser()
            ]
        );

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function storeFail(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $agent = new Agent();

        if ($user) {
            History::create(
                [
                    'user_id' => $user->id,
                    'success' => false,
                    'ip' => $request->ip(),
                    'browser' => $agent->browser()
                ]
            );
        }

        return redirect()->back()->withErrors($request->errors);
    }
}