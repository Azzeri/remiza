<?php

namespace App\Http\Controllers;

use App\Models\Cathegory;
// use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use App\Models\Item;
use App\Models\ItemDatabase;
use App\Models\Service;
use App\Models\ServiceDatabase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    public function index()
    {          
        $items = Item::with('databaseItems', 'fireBrigadeUnit', 'cathegory', 'manufacturer')->where('fire_brigade_unit_id', Auth::user()->fire_brigade_unit_id)->get();
        $dbitems = ItemDatabase::all();
        $cathegories = Cathegory::with('subcathegories', 'parent', 'itemsdb')->get();

        return Inertia::render('items', ['items' => $items, 'cathegories' => $cathegories, 'dbitems' => $dbitems]);
    }

    public function itemDetails(Item $item)
    {

        $dbservices = ServiceDatabase::where('cathegory_id', $item->databaseItems->cathegory_id)->get();
        $services = Service::where('item_id', $item->id)->with('serviceDatabase', 'user')->get();

        return Inertia::render('itemDetails', ['item' => $item, 'services' => $services, 'dbservices' => $dbservices]);
    }

    public function store(Request $request)
    {
        $request->checked == true?
        $date = '9999-01-01':
        $date = $request->date;
        
        Item::create(
            [
                $request->validate([
                    'item' => 'required',
                ]),
                'expiry_date' => $date,
                'item_database_id' => $request->item,
                'fire_brigade_unit_id' => Auth::user()->fire_brigade_unit_id

            ]
        );


        return redirect()->back()
            ->with('message', 'Sukces');
    }

    // public function update(Request $request)
    // {
    //     if ($request->has('id'))
    //         $avoid = Item::find($request->input('id'));

    //     Validator::make($request->all(), [
    //         'name' => ['required', 'string', 'min:3', 'max:32', Rule::unique('cathegories')->ignore($avoid)],
    //     ])->validate();

    //     if ($request->has('id')) {
    //         Item::find($request->input('id'))->update($request->all());
    //         return redirect()->back()
    //             ->with('message', 'Sukces');
    //     }
    // }

    // public function destroy(Request $request)
    // {
    //     if ($request->has('id')) {
    //         Cathegory::find($request->input('id'))->delete();
    //         return redirect()->back();
    //     }
    // }
}
