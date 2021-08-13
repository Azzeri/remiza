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
        $cathegories = Cathegory::with('subcathegories')->get();

        return Inertia::render('cathegories', ['data' => $cathegories]);
    }

    public function store()
    {
        Request::get('parent') == -1 ?
            $parent = NULL : $parent = Request::get('parent');

        Cathegory::create(
            [
                Request::validate([
                    'name' => ['unique:cathegories', 'required', 'string', 'min:3', 'max:32'],
                ]),

                'name' => Request::get('name'),
                'cathegory_id' => $parent,
            ]
        );


        return redirect()->back()
            ->with('message', 'Sukces');
    }

    public function update(Cathegory $cathegory)
    {
        Request::get('parent') == -1 ?
            $parent = NULL : $parent = Request::get('parent');


        $cathegory->update(
            [
                Request::validate([
                    'name' => ['required', 'string', 'min:3', 'max:32', Rule::unique('cathegories')->ignore(Cathegory::find($cathegory->id))]
                ]),
                'name' => Request::get('name'),
                'cathegory_id' => $parent
            ]

        );

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
