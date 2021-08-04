<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\User;


class UserController extends Controller
{
    public function index()
    {
        // $users = User::all();
        Auth::user()->privilege_id == 1 ?
            $users = User::with('privilege', 'fireBrigadeUnit')->get()
            :
            $users = User::with('privilege', 'fireBrigadeUnit')->where('fire_brigade_unit_id', Auth::user()->fire_brigade_unit_id)->get();

        return Inertia::render('users', ['users' => $users]);
    }
}
