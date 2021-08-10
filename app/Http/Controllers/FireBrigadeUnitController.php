<?php

namespace App\Http\Controllers;

use App\Models\FireBrigadeUnit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class FireBrigadeUnitController extends Controller
{
    public function index()
    {
        $units = FireBrigadeUnit::all();

        return Inertia::render('fireBrigadeUnits', ['data' => $units]);
    }

    public function store()
    {

        Validator::make(Request::all(), [
            'name' => ['unique:fire_brigade_units', 'required', 'string', 'min:3', 'max:32'],
            'address' => ['required'],
            'username' => 'required|string|min:3|max:32',
            'surname' => 'required|string|min:3|max:32',
            'email' => 'unique:users|required|email',
            'phone' => 'nullable|size:9',
        ])->validate();

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
        $user->save();

        return redirect()->back()
            ->with('message', 'Sukces');
    }

    public function update(FireBrigadeUnit $unit)
    {
        echo $unit;
        // $unit->update(
        //     Request::validate([
        //         'name' => [ Rule::unique('fire_brigade_units')->ignore(FireBrigadeUnit::find($unit->id)), 'required', 'string', 'min:3', 'max:32'],
        //         'address' => ['required'],
        //     ])
        // );

        // return redirect()->back()
        //     ->with('message', 'Sukces');
    }
}
