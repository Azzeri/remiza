<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Privilege;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Jenssegers\Agent\Agent;

class HistoryController extends Controller
{
    public function index($id)
    {
        if (Auth::user()->privilege_id != Privilege::IS_GLOBAL_ADMIN && User::find($id)->privilege_id == Privilege::IS_GLOBAL_ADMIN) 
            return Redirect::route('dashboard');

        $this->authorize('update', User::find($id), User::class);

        $history = History::where('user_id', $id)->paginate(10);
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
