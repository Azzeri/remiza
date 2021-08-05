<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use App\Models\Cathegory;
use Illuminate\Validation\Rule;

class CathegoryController extends Controller
{
    public function index()
    {
        $cathegories = Cathegory::all();

        return Inertia::render('cathegories', ['cathegories' => $cathegories]);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'unique:cathegories|required|string|min:3|max:32',
        ])->validate();

        Cathegory::create($request->all());

        return redirect()->back()
            ->with('message', 'Sukces');
    }

    public function update(Request $request)
    {
        if ($request->has('id'))
            $avoid = Cathegory::find($request->input('id'));

        Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:3', 'max:32', Rule::unique('cathegories')->ignore($avoid)],
        ])->validate();

        if ($request->has('id')) {
            Cathegory::find($request->input('id'))->update($request->all());
            return redirect()->back()
                ->with('message', 'Sukces');
        }
    }

    // public function destroy(Request $request)
    // {
    //     if ($request->has('id')) {
    //         Cathegory::find($request->input('id'))->delete();
    //         return redirect()->back();
    //     }
    // }
}
