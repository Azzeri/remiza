<?php

namespace App\Http\Controllers;

use App\Models\FireBrigadeUnit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Request;

class FireBrigadeUnitController extends Controller
{
    public function index()         
    {
        $units = FireBrigadeUnit::all();

        return Inertia::render('fireBrigadeUnits', ['data' => $units]);
    }

    public function store()
    {
        FireBrigadeUnit::create(
            Request::validate([
                'name' => ['unique:fire_brigade_units', 'required', 'string', 'min:3', 'max:32'],
                'address' => ['required']
            ])
        );

        return redirect()->back()
            ->with('message', 'Sukces');
    }

    // public function update(Cathegory $cathegory)
    // {
    //     $cathegory->update(
    //         Request::validate([
    //             'name' => ['required', 'string', 'min:3', 'max:32', Rule::unique('cathegories')->ignore(Cathegory::find($cathegory->id))]
    //         ])
    //     );

    //     return redirect()->back()
    //         ->with('message', 'Sukces');
    // }
}
