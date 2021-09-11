<?php

namespace App\Http\Controllers;

use App\Models\FireBrigadeUnit;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Request;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::user()->privilege_id == 1) {
            $units = FireBrigadeUnit::all();
            $users = User::with('privilege', 'fireBrigadeUnit')->orderBy('name')->paginate(10);
        } else {
            $units = FireBrigadeUnit::where('id', Auth::user()->fire_brigade_unit_id)->get();
            $users = User::with('privilege', 'fireBrigadeUnit')->where('fire_brigade_unit_id', Auth::user()->fire_brigade_unit_id)->orderBy('name')->paginate(10);
        }
        return Inertia::render('users',['data' => $users, 'units' => $units]);
    } 

    public function store()
    {
        Request::validate([
            'name' => 'required|string|min:3|max:32',
            'surname' => 'required|string|min:3|max:32',
            'email' => 'unique:users|required|email:filter',
            'phone' => 'nullable|size:9',
        ]);

        $google2fa = app('pragmarx.google2fa');
        $key = $google2fa->generateSecretKey();

        Auth::user()->privilege_id == 1 ? 
            $unit = Request::get('unit'):
            $unit = Auth::user()->fire_brigade_unit_id;

        User::create(
            [
                'name' => Request::get('name'),
                'surname' => Request::get('surname'),
                'email' => Request::get('email'),
                'phone' => Request::get('phone'),
                'password' => Hash::make('qwerty'),
                'privilege_id' => 3,
                'fire_brigade_unit_id' => $unit,
                'google2fa_secret' => $key
                // 'fire_brigade_unit_id' => Auth::user()->fire_brigade_unit_id
            ]
        );

        $details = [
            'title' => 'Witaj w jednostce',
        ];

        Mail::to(Request::get('email'))->send(new \App\Mail\WelcomeMail($details));


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

    public function changePassword()
    {
        $user = Auth::user();
        $userPassword = $user->password;

        Request::validate([
            'password_old' => 'required',
            'password' => 'required|same:password_confirmation|min:6|different:password_old',
            'password_confirmation' => 'required',
        ]);

        if (!Hash::check(Request::get('password_old'), $userPassword)) {
            return back()->withErrors(['current_password' => 'Obecne hasło jest nieprawidłowe']);
        }

        $user->password = Hash::make(Request::get('password'));
        $user->first_time_login = false;
        $user->save();

        return redirect()->back()
            ->with('message', 'Sukces');
    }

    public function mfa()
    {
        $google2fa = app('pragmarx.google2fa');
        $key = Auth::user()->google2fa_secret;

        $QR_Image = $google2fa->getQRCodeInline(
            config('app.name'),
            Auth::user()->email,
            $key
        );

        return Inertia::render('Mfa', ['QR_Image' => $QR_Image, 'secretkey' => $key]);
    }

    public function mfaconfirm()
    {
        $user = Auth::user();
        $user->mfaverified = true;
        $user->save();

        return redirect('dashboard');
    }
}
