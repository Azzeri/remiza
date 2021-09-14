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

        Auth::user()->privilege_id == Privilege::IS_GLOBAL_ADMIN
            ? $units = FireBrigadeUnit::with('superiorUnit')->get()
            : $units = FireBrigadeUnit::where('id', Auth::user()->fire_brigade_unit_id)->orWhere('superior_unit_id', Auth::user()->fire_brigade_unit_id)->with('superiorUnit')->get();

        return Inertia::render('fireBrigadeUnits', ['data' => $units]);
    }

    public function store()
    {
        // $this->authorize('fireBrigadeUnits');

        Validator::make(Request::all(), [
            'name' => ['unique:fire_brigade_units', 'required', 'string', 'min:3', 'max:32'],
            'address' => ['required', 'min:3', 'max:255'],
            'username' => 'required|string|min:3|max:32',
            'surname' => 'required|string|min:3|max:32',
            'email' => 'unique:users|required|email',
            'phone' => 'nullable|size:9',
        ])->validate();


        $google2fa = app('pragmarx.google2fa');
        $key = $google2fa->generateSecretKey();

        $unit = new FireBrigadeUnit();
        $unit['name'] = Request::get('name');
        $unit['address'] = Request::get('address');
        $unit->save();

        $user = new User();
        $user['name'] = Request::get('username');
        $user['surname'] = Request::get('surname');
        $user['email'] = Request::get('email');
        $user['phone'] = Request::get('phone');
        $user['password'] = Hash::make('qwerty');
        $user['privilege_id'] = 2;
        $user['fire_brigade_unit_id'] = $unit->id;
        $user['google2fa_secret'] = $key;
        $user->save();

        $details = [
            'title' => 'Witaj w jednostce',
        ];

        Mail::to(Request::get('email'))->send(new \App\Mail\WelcomeMail($details));

        return redirect()->back()
            ->with('message', 'Sukces');
    }

    //Functions below have a problem locating the unit in db automatically
    public function update()
    {
        // $this->authorize('fireBrigadeUnits');

        $unit = FireBrigadeUnit::find(Request::get('id'));

        $unit->update(
            Request::validate([
                'name' => [Rule::unique('fire_brigade_units')->ignore(FireBrigadeUnit::find($unit->id)), 'required', 'string', 'min:3', 'max:32'],
                'address' => ['required'],
            ])
        );

        return redirect()->back()
            ->with('message', 'Sukces');
    }

    public function destroy($id)
    {
        // $this->authorize('fireBrigadeUnits');

        $unit = FireBrigadeUnit::find($id);
        $unit->delete();
        return redirect()->back()
            ->with('message', 'Sukces');
    }
}
