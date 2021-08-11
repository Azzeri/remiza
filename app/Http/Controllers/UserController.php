<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Request;

class UserController extends Controller
{
    public function index()
    {
        Auth::user()->privilege_id == 1 ?
            $users = User::with('privilege', 'fireBrigadeUnit')->orderBy('name')->get()
            :
            $users = User::with('privilege', 'fireBrigadeUnit')->where('fire_brigade_unit_id', Auth::user()->fire_brigade_unit_id)->orderBy('name')->get();

        return Inertia::render('users', ['data' => $users]);
    }

    public function store()
    {
        User::create(
            [
                Request::validate([
                    'name' => 'required|string|min:3|max:32',
                    'surname' => 'required|string|min:3|max:32',
                    'email' => 'unique:users|required|email',
                    'phone' => 'nullable|size:9',
                ]),
                'name' => Request::get('name'),
                'surname' => Request::get('surname'),
                'email' => Request::get('email'),
                'phone' => Request::get('phone'),
                'password' => Hash::make('qwerty'),
                'privilege_id' => 3,
                'fire_brigade_unit_id' => Auth::user()->fire_brigade_unit_id
            ]
        );

        return redirect()->back()
            ->with('message', 'Sukces');
    }

    public function update(User $user)
    {
        $user->update(
            Request::validate([
                'name' => 'required|string|min:3|max:32',
                'surname' => 'required|string|min:3|max:32',
                'email' => ['required', 'email', Rule::unique('users')->ignore(User::find($user->id))],
                'phone' => 'nullable|size:9',
            ])
        );

        return redirect()->back()
            ->with('message', 'Sukces');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->back()
            ->with('message', 'Sukces');
    }
}
