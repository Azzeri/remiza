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
use App\Models\FireBrigadeUnit;
use App\Models\Usage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    public function index()
    {
        $dbitems = ItemDatabase::all();
        $cathegories = Cathegory::with('subcathegories', 'parent', 'itemsdb')->get();

        if (Auth::user()->privilege_id == 1) {
            $units = FireBrigadeUnit::all();
            $items = Item::with('databaseItems', 'fireBrigadeUnit', 'cathegory', 'manufacturer')->paginate(10);
        } else {
            $units = FireBrigadeUnit::where('id', Auth::user()->fire_brigade_unit_id)->get();
            $items = Item::with('databaseItems', 'fireBrigadeUnit', 'cathegory', 'manufacturer')->where('fire_brigade_unit_id', Auth::user()->fire_brigade_unit_id)->paginate(10);
        }

        return Inertia::render('items', ['items' => $items, 'cathegories' => $cathegories, 'dbitems' => $dbitems, 'units' => $units]);
    }

    public function itemDetails(Item $item)
    {

        $dbservices = ServiceDatabase::where('cathegory_id', $item->databaseItems->cathegory_id)->get();
        $services = Service::where('item_id', $item->id)->with('serviceDatabase', 'user')->get();

        return Inertia::render('itemDetails', ['item' => $item, 'services' => $services, 'dbservices' => $dbservices]);
    }

    public function store(Request $request)
    {
        if ($request->checked == true)
            $date = '9999-01-01';
        else {
            $request->validate([
                'date' => ['required'],
            ]);
            $date = $request->date;
        };

        Item::create(
            [
                $request->validate([
                    'item' => 'required',
                ]),
                'expiry_date' => $date,
                'item_database_id' => $request->item,
                'fire_brigade_unit_id' => $request->unit

            ]
        );

        return redirect()->back()
            ->with('message', 'Sukces');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->back()
            ->with('message', 'Sukces');
    }

    public function update(Request $request, Item $item)
    {
        if ($request->checked == true)
            $date = '9999-01-01';
        else {
            $request->validate([
                'date' => ['required'],
            ]);
            $date = $request->date;
        };


        $item->expiry_date = $date;
        $item->save();

        return redirect()->back()
            ->with('message', 'Sukces');
    }

    public function history($id)
    {
        $services = Service::where('item_id', $id)->where('is_performed',1)->with('serviceDatabase', 'user')->orderBy('perform_date','desc')->get();
        $usages = Usage::where('item_id', $id)->with('user')->orderBy('usage_date','desc')->get();
        return Inertia::render('history', ['services' => $services, 'usages' => $usages]);
    }
}
