<?php

namespace App\Http\Controllers;

use App\Models\FireBrigadeUnit;
use App\Models\User;
use App\Models\Privilege;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class FireBrigadeUnitController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', FireBrigadeUnit::class);

        $units = Auth::user()->privilege_id == Privilege::IS_GLOBAL_ADMIN
            ? FireBrigadeUnit::with('superiorUnit')->get()
            : FireBrigadeUnit::where('id', Auth::user()->fire_brigade_unit_id)->orWhere('superior_unit_id', Auth::user()->fire_brigade_unit_id)->with('superiorUnit')->get();

        return Inertia::render('fireBrigadeUnits', ['data' => $units]);
    }

    public function store()
    {
        $this->authorize('create', FireBrigadeUnit::class);

        Request::validate([
            'name' => ['unique:fire_brigade_units', 'required', 'string', 'min:3', 'max:32'],
            'address' => ['required', 'min:3', 'max:255'],
            'username' => 'required|string|min:3|max:32',
            'surname' => 'required|string|min:3|max:32',
            'email' => 'unique:users|required|email:filter',
            'phone' => 'nullable|size:9',
            'superior' => 'required'
        ]);

        $superior = Request::get('superior') ? Request::get('superior') : NULL;
        $user_id = Request::get('superior') ? 2 : 4;

        // $google2fa = app('pragmarx.google2fa');
        // $key = $google2fa->generateSecretKey();
        // // $user['google2fa_secret'] = $key;

        $unit = FireBrigadeUnit::create([
            'name' => Request::get('name'),
            'address' => Request::get('address'),
            'superior_unit_id' => $superior,
        ]);

        $user = User::create([
            'name' => Request::get('username'),
            'surname' => Request::get('surname'),
            'email' => Request::get('email'),
            'phone' => Request::get('phone'),
            'password' => Hash::make('qwerty'),
            'privilege_id' => $user_id,
            'fire_brigade_unit_id' => $unit->id,
        ]);

        Mail::to(Request::get('email'))->send(new \App\Mail\WelcomeMail([
            'title' => 'Witaj w jednostce',
            'password' => $user->password
        ]));

        return redirect()->back()
            ->with('message', 'Sukces');
    }

    public function update(FireBrigadeUnit $fireBrigadeUnit)
    {   
        $this->authorize('update', $fireBrigadeUnit, FireBrigadeUnit::class);

        $fireBrigadeUnit->update(
            Request::validate([
                'name' => [Rule::unique('fire_brigade_units')->ignore(FireBrigadeUnit::find($fireBrigadeUnit->id)), 'required', 'string', 'min:3', 'max:32'],
                'address' => ['required'],
            ])
        );

        return redirect()->back()
            ->with('message', 'Sukces');
    }

    public function destroy(FireBrigadeUnit $fireBrigadeUnit)
    {
        $this->authorize('delete', $fireBrigadeUnit, FireBrigadeUnit::class);

        $fireBrigadeUnit->delete();
        return redirect()->back()
            ->with('message', 'Sukces');
    }
}
