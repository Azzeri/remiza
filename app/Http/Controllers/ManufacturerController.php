<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $queryManufacturer=Manufacturer::query();

        $manufacturers = $queryManufacturer->paginate(10)->through(fn ($manufacturer) => [
            'id' => $manufacturer->id,
            'name' => $manufacturer->name,
        ]);

        return Inertia::render('manufacturers', ['data' => $manufacturers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['unique:manufacturers', 'required', 'string', 'min:3', 'max:32'],
        ]);

        Manufacturer::create(['name' => ucfirst($request->name)]);

        return redirect()->back()->with('message', 'Sukces');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Manufacturer  $manufacturer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Manufacturer $manufacturer)
    {
        $this->authorize('update', $manufacturer, Manufacturer::class);

        $request->validate([
            'name' => [Rule::unique('manufacturers')->ignore(Manufacturer::find($manufacturer->id)), 'required', 'string', 'min:3', 'max:32'],

        ]);

        $manufacturer->update(['name' => ucfirst($request->name)]);

        return redirect()->back()->with('message', 'Sukces');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Manufacturer  $manufacturer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Manufacturer $manufacturer)
    {
        $this->authorize('delete', $manufacturer, Manufacturer::class);
        
        $manufacturer->delete();

        return redirect()->back() ->with('message', 'Sukces');
    }
}
