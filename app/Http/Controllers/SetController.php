<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class SetController extends Controller
{
    public function index()
    {
        return 'Brak zestawów';
        // $sets = Item::all();
        // return Inertia::render('sets', ['set' => $sets[0], 'sets' => $sets]);
    }

    public function setDetails($id)
    {
        $set = null;

        if ($id != 0) {
            if (Set::with('itemsdb')->where('id', $id)->first())
                $set = Set::with('items','itemsdb')->where('id', $id)->first();
            else {
                if (Set::first())
                    return Redirect::route('set.details', Set::first()->id);
                else
                    return Redirect::route('set.details', 0);
            };
        }

        $sets = Set::all();

        Auth::user()->privilege_id == 1 ?
            $items = Item::with('databaseItems')->get() :
            $items = Item::where('fire_brigade_unit_id', Auth::user()->fire_brigade_unit_id)->with('databaseItems')->get();
        return Inertia::render('sets', ['set' => $set, 'sets' => $sets, 'items' => $items],);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:32',
            'selected' => 'min:1'
        ]);

        Auth::user()->privilege_id == 1 ?
            $unit_id = 1 :
            $unit_id = Auth::user()->fire_brigade_unit_id;

        Set::create(
            [
                'name' => $request->name,
                'user_id' =>  Auth::user()->id,
                'fire_brigade_unit_id' => $unit_id
            ]
        );

        $set = Set::orderBy('created_at', 'desc')->first();
        foreach ($request->selected as $row)
            $set->items()->attach($row['id']);

        return Redirect::route('set.details', $set->id);
    }

    public function update(Request $request, Set $set)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:32',
            'selected' => 'min:1'
        ]);

        $set->update(['name' => $request->name]);
        $set->items()->detach();

        foreach ($request->selected as $row)
            $set->items()->attach($row['id']);

        return redirect()->back()
            ->with('message', 'Sukces');
    }

    public function destroy(Set $set)
    {
        $set->delete();
        $set->items()->detach();

        return redirect()->back()
            ->with('message', 'Sukces');
    }
}
