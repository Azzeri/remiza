<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Cathegory;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Request;

class CathegoryController extends Controller
{
    public function index()
    {
        $cathegories = Cathegory::all();

        return Inertia::render('cathegories', ['data' => $cathegories]);
    }

    public function store()
    {
        Cathegory::create(
            Request::validate([
                'name' => ['unique:cathegories', 'required', 'string', 'min:3', 'max:32'],
            ])
        );

        return redirect()->back()
            ->with('message', 'Sukces');
    }

    public function update(Cathegory $cathegory)
    {
        $cathegory->update(
            Request::validate([
                'name' => ['required', 'string', 'min:3', 'max:32', Rule::unique('cathegories')->ignore(Cathegory::find($cathegory->id))]
            ])
        );

        return redirect()->back()
            ->with('message', 'Sukces');
    }
    // public function destroy(Request $request)
    // {
    //     if ($request->has('id')) {
    //         Cathegory::find($request->input('id'))->delete();
    //         return redirect()->back();
    //     }
    // }
}
