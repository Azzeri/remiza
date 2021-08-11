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
        $cathegories = Cathegory::with('subcathegories')->orderBy('name')->get();

        return Inertia::render('cathegories', ['data' => $cathegories]);
    }

    public function store()
    {
        if (Request::get('parent') == -1) {
            Cathegory::create(
                Request::validate([
                    'name' => ['unique:cathegories', 'required', 'string', 'min:3', 'max:32'],
                ])
            );
        } else {
            Cathegory::create(
                [
                    Request::validate([
                        'name' => ['unique:cathegories', 'required', 'string', 'min:3', 'max:32'],
                    ]),

                    'name' => Request::get('name'),
                    'cathegory_id' => Request::get('parent'),
                ]
            );
        }

        return redirect()->back()
            ->with('message', 'Sukces');
    }

    public function update(Cathegory $cathegory)
    {
        if (Request::get('parent') == -1) {
            $cathegory->update(
                [
                    Request::validate([
                        'name' => ['required', 'string', 'min:3', 'max:32', Rule::unique('cathegories')->ignore(Cathegory::find($cathegory->id))]
                    ]),
                    'name' => Request::get('name'),
                    'cathegory_id' => NULL
                ]

            );
        } else {
            $cathegory->update(
                [
                    Request::validate([
                        'name' => ['required', 'string', 'min:3', 'max:32', Rule::unique('cathegories')->ignore(Cathegory::find($cathegory->id))]
                    ]),
                    'name' => Request::get('name'),
                    'cathegory_id' => Request::get('parent')
                ]

            );
        }

        return redirect()->back()
            ->with('message', 'Sukces');
    }

    public function destroy(Cathegory $cathegory)
    {
        $cathegory->delete();
        $cathegory->subcathegories->each->delete();
        $cathegory->itemsdb->each->delete();
        $cathegory->items->each->delete();
        $cathegory->servicesdb->each->delete();
        $cathegory->services->each->delete();

        return redirect()->back()
            ->with('message', 'Sukces');
    }
}
