<?php

namespace App\Http\Controllers;

use App\Models\Cathegory;
use App\Models\Fill;
// use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Item;
use App\Models\ItemDatabase;
use App\Models\Service;
use App\Models\ServiceDatabase;
use App\Models\FireBrigadeUnit;
use App\Models\Manufacturer;
use App\Models\Privilege;
use App\Models\Usage;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $dbitems = ItemDatabase::all();
        $manufacturers = Manufacturer::all();

        if (Auth::user()->privilege_id == Privilege::IS_GLOBAL_ADMIN) {
            $units = FireBrigadeUnit::all();
            $items = Item::with('databaseItems', 'fireBrigadeUnit', 'cathegory', 'manufacturer', 'vehicle')->orderBy('fire_brigade_unit_id', 'asc')->paginate(10);
            $vehicles = Vehicle::all();
        } else if (Auth::user()->privilege_id == Privilege::IS_SUPERIOR_UNIT_ADMIN) {
            $units = FireBrigadeUnit::where('id', Auth::user()->fire_brigade_unit_id)->orWhere('superior_unit_id', Auth::user()->fire_brigade_unit_id)->get();

            $unitIds = [Auth::user()->fire_brigade_unit_id];
            foreach ($units as $unit) {
                if ($unit->superior_unit_id == Auth::user()->fire_brigade_unit_id)
                    array_push($unitIds, $unit->id);
            }

            $items = Item::whereIn('fire_brigade_unit_id', $unitIds)->with('databaseItems', 'fireBrigadeUnit', 'cathegory', 'manufacturer', 'vehicle')->orderBy('fire_brigade_unit_id', 'asc')->paginate(10);
            $vehicles = Vehicle::whereIn('fire_brigade_unit_id', $unitIds)->get();
        } else {

            $units = FireBrigadeUnit::where('id', Auth::user()->fire_brigade_unit_id)->get();
            $items = Item::with('databaseItems', 'fireBrigadeUnit', 'cathegory', 'manufacturer')->where('fire_brigade_unit_id', Auth::user()->fire_brigade_unit_id)->orderBy('fire_brigade_unit_id', 'asc')->paginate(10);
            $vehicles = Vehicle::where('fire_brigade_unit_id', Auth::user()->fire_brigade_unit_id)->get();
        }

        return Inertia::render('items', ['items' => $items, 'manufacturers' => $manufacturers, 'dbitems' => $dbitems, 'units' => $units, 'vehicles' => $vehicles]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'construction_number' => 'nullable|string|min:3|max:32',
            'inventory_number' => 'nullable|string|min:3|max:32',
            'identification_number' => 'nullable|string|min:3|max:32',
            'name' => 'nullable|string|min:3|max:32|alpha',
            'date_production' => 'nullable|date',
            'date_expiry' => 'nullable|date',
            'date_legalisation' => 'nullable|date',
            'date_legalisation_due' => 'nullable|date',
            'stencil' => 'required'
        ]);

        if (Auth::user()->privilege_id == Privilege::IS_GLOBAL_ADMIN || Auth::user()->privilege_id == Privilege::IS_SUPERIOR_UNIT_ADMIN) {
            if (!$request->unit) abort(401);
            $unit = $request->unit;
        } else $unit = Auth::user()->fire_brigade_unit_id;

        Item::create([
            'construction_number' => $request->construction_number,
            'inventory_number' => $request->inventory_number,
            'identification_number' => $request->identification_number,
            'name' => $request->name,
            'date_expiry' => $request->date_expiry,
            'date_legalisation' => $request->date_legalisation,
            'date_legalisation_due' => $request->date_legalisation_due,
            'date_production' => $request->date_production,
            'item_database_id' => $request->stencil,
            'fire_brigade_unit_id' => $unit,
            'manufacturer_id' => $request->manufacturer,
            'vehicle_id' => $request->vehicle,
        ]);

        return redirect()->back()
            ->with('message', 'Sukces');
    }

    public function update(Request $request, Item $item)
    {
        $this->authorize('update', $item, Item::class);

        $request->validate([
            'construction_number' => 'nullable|string|min:3|max:32',
            'inventory_number' => 'nullable|string|min:3|max:32',
            'identification_number' => 'nullable|string|min:3|max:32',
            'name' => 'nullable|string|min:3|max:32|alpha',
            'date_production' => 'nullable|date',
            'date_expiry' => 'nullable|date',
            'date_legalisation' => 'nullable|date',
            'date_legalisation_due' => 'nullable|date',
        ]);

        $item->update([
            'construction_number' => $request->construction_number,
            'inventory_number' => $request->inventory_number,
            'identification_number' => $request->identification_number,
            'name' => $request->name,
            'date_expiry' => $request->date_expiry,
            'date_legalisation' => $request->date_legalisation,
            'date_legalisation_due' => $request->date_legalisation_due,
            'date_production' => $request->date_production,
            'manufacturer_id' => $request->manufacturer,
            'vehicle_id' => $request->vehicle,
        ]);

        return redirect()->back()
            ->with('message', 'Sukces');
    }

    public function destroy(Item $item)
    {
        $this->authorize('delete', $item, Item::class);

        $item->delete();
        return redirect()->back()
            ->with('message', 'Sukces');
    }

    public function history($id, $n)
    {
        $item = Item::with('cathegory')->where('id', $id)->first();
        $this->authorize('view', $item, Item::class);

        $services = Service::where('item_id', $id)->where('is_performed', 1)->with('serviceDatabase', 'user')->orderBy('perform_date', 'desc')->paginate(3,['*'], 'services');
        $usages = Usage::where('item_id', $id)->with('user')->orderBy('usage_date', 'desc')->paginate(3,['*'], 'usages');
        $fills = Fill::where('item_id', $id)->with('user')->paginate(3, ['*'], 'fills');

        return Inertia::render('history', ['services' => $services, 'usages' => $usages, 'item' => $item, 'fills' => $fills, 'n'=>$n]);
    }

    public function itemDetails(Item $item)
    {
        $this->authorize('view', $item, Item::class);

        $dbservices = ServiceDatabase::where('cathegory_id', $item->databaseItems->cathegory_id)->get();
        $services = Service::where('item_id', $item->id)->with('serviceDatabase', 'user')->get();
        $cathegory = $item->cathegory->cathegory;

        return Inertia::render('itemDetails', ['item' => $item, 'services' => $services, 'dbservices' => $dbservices, 'cathegory' => $cathegory]);
    }
}
