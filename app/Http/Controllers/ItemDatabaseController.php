<?php

namespace App\Http\Controllers;

use App\Models\Cathegory;
use App\Models\ItemDatabase;
use App\Models\ServiceDatabase;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ItemDatabaseController extends Controller
{
    public function index()
    {
        // $dbservices = ServiceDatabase::all();
        // $dbitems = ItemDatabase::with('cathegory')->paginate(10);
        // $cathegories = Cathegory::all();

        $queryServiceDatabase=ServiceDatabase::query();
        $queryItemDatabase=ItemDatabase::query();
        $queryCathegory=Cathegory::query();


        $dbservices = $queryServiceDatabase->get()->map(fn($ServiceDatabase) => [
            'id' => $ServiceDatabase->id,
        ]);
        $dbitems = $queryItemDatabase->paginate(10)->through(fn($ItemDatabase) => [
            'id' => $ItemDatabase->id,
            'stencil_name' => $ItemDatabase->stencil_name,
            'cathegory' => array(
                'id' => $ItemDatabase->Cathegory->id,
                'name' => $ItemDatabase->Cathegory->name,
            ),//jak 'cathegory' z $dbitems można połączyć z $cathegories?
            'name' => $ItemDatabase->name,
            'construction_number' => $ItemDatabase->construction_number,
            'inventory_number' => $ItemDatabase->inventory_number,
            'identification_number' => $ItemDatabase->identification_number,
            'date_production' => $ItemDatabase->date_production,
            'date_expiry' => $ItemDatabase->date_expiry,
            'date_legalisation' => $ItemDatabase->date_legalisation,
            'date_legalisation_due' => $ItemDatabase->date_legalisation_due,
            'manufacturer' => $ItemDatabase->manufacturer,
            'vehicle' => $ItemDatabase->vehicle,
        ]);
        $cathegories = $queryCathegory->get()->map(fn($cathegory) => [
            'id' => $cathegory->id,
            'name' => $cathegory->name,
        ]);

        return Inertia::render('stencils', ['dbitems' => $dbitems, 'dbservices' => $dbservices, 'cathegories' => $cathegories]);
    }

    public function store()
    {
        ItemDatabase::create(Request::validate([
            'cathegory_id' => 'required',
            'stencil_name' => 'required|unique:item_databases|min:3|max:25',
            'construction_number' => 'boolean',
            'inventory_number' => 'boolean',
            'identification_number' => 'boolean',
            'name' => 'boolean',
            'date_production' => 'boolean',
            'date_expiry' => 'boolean',
            'date_legalisation' => 'boolean',
            'date_legalisation_due' => 'boolean',
            'manufacturer' => 'boolean',
            'vehicle' => 'boolean',
        ]));

        return redirect()->back()->with('message', 'Sukces');
    }

    public function update($itemDatabase)
    {   
        $item = ItemDatabase::find($itemDatabase);
        $this->authorize('update', $item, ItemDatabase::class);

        $item->update(Request::validate([
            'cathegory_id' => 'required',
            'stencil_name' => ['required', 'min:3', 'max:25', Rule::unique('item_databases')->ignore($item)],
            'construction_number' => 'boolean',
            'inventory_number' => 'boolean',
            'identification_number' => 'boolean',
            'name' => 'boolean',
            'date_production' => 'boolean',
            'date_expiry' => 'boolean',
            'date_legalisation' => 'boolean',
            'date_legalisation_due' => 'boolean',
            'manufacturer' => 'boolean',
            'vehicle' => 'boolean',
        ]));

        return redirect()->back()->with('message', 'Sukces');
    }

    public function destroy($itemDatabase)
    {
        $item = ItemDatabase::find($itemDatabase);
        $this->authorize('delete', $item, ItemDatabase::class);

        $item->delete();

        return redirect()->back()->with('message', 'Sukces');

    }
}
