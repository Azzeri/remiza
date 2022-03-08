<?php

namespace App\Http\Controllers;

use App\Models\FireBrigadeUnit;
use App\Models\Privilege;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $vehicles = Vehicle::paginate(2)->through(fn ($vehicle) => [
            //     'id' => $vehicle->id,
            //     'number' => $vehicle->number,
            //     'name' => $vehicle->name,
            // ]);

        if (Auth::user()->privilege_id == Privilege::IS_GLOBAL_ADMIN) {

            $vehicles = Vehicle::with('unit')->paginate(1);
            $units = FireBrigadeUnit::all();

        } else if (Auth::user()->privilege_id == Privilege::IS_SUPERIOR_UNIT_ADMIN) {
            $units = FireBrigadeUnit::where('id', Auth::user()->fire_brigade_unit_id)->orWhere('superior_unit_id', Auth::user()->fire_brigade_unit_id)->get();

            $unitIds = [Auth::user()->fire_brigade_unit_id];
            foreach ($units as $unit) {
                if ($unit->superior_unit_id == Auth::user()->fire_brigade_unit_id)
                    array_push($unitIds, $unit->id);
            }

            $vehicles = Vehicle::with('unit')->whereIn('fire_brigade_unit_id', $unitIds)->paginate(10);
        } else {
            $vehicles = Vehicle::with('unit')->where('fire_brigade_unit_id', Auth::user()->fire_brigade_unit_id)->paginate(10);
            $units = FireBrigadeUnit::where('id', Auth::user()->fire_brigade_unit_id)->get();
        }

        return Inertia::render('vehicles', ['data' => $vehicles, 'units' => $units]);
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
            'name' => ['unique:vehicles', 'required', 'string', 'min:3', 'max:32', 'alpha_dash'],
            'number' => ['unique:vehicles', 'required', 'string', 'min:1', 'max:32']
        ]);

        Auth::user()->privilege_id == Privilege::IS_GLOBAL_ADMIN || Auth::user()->privilege_id == Privilege::IS_SUPERIOR_UNIT_ADMIN
            ? $unit = $request->unit
            : $unit = Auth::user()->fire_brigade_unit_id;

        Vehicle::create([
            'name' => ucfirst($request->name),
            'number' => $request->number,
            'fire_brigade_unit_id' => $unit
        ]);

        return redirect()->back()->with('message', 'Sukces');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $this->authorize('update', $vehicle, Vehicle::class);

        $request->validate([
            'name' => [Rule::unique('vehicles')->ignore(Vehicle::find($vehicle->id)), 'required', 'string', 'min:3', 'max:32', 'alpha_dash'],
            'number' => [Rule::unique('vehicles')->ignore(Vehicle::find($vehicle->id)), 'required', 'string', 'min:1', 'max:32']
        ]);

        $vehicle->update([
            'name' => ucfirst($request->name),
            'number' => $request->number
        ]);

        return redirect()->back()->with('message', 'Sukces');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle)
    {
        $this->authorize('delete', $vehicle, Vehicle::class);

        $vehicle->delete();

        return redirect()->back()->with('message', 'Sukces');
    }
}
