<?php

namespace App\Http\Controllers;

use App\Models\FireBrigadeUnit;
use App\Models\Privilege;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $services = Service::with('serviceDatabase', 'item')->where('is_performed', false)->orderBy('perform_date', 'asc')->get();
        $services_to_send = [];

        foreach ($services as $service) {
            if ((($service->item->fire_brigade_unit_id == Auth::user()->fire_brigade_unit_id) ||
                    ($service->item->fireBrigadeUnit->superior_unit_id == Auth::user()->fire_brigade_unit_id) ||
                    (Auth::user()->privilege_id == Privilege::IS_GLOBAL_ADMIN)) &&
                ($service->perform_date < Carbon::now() || $service->perform_date < Carbon::now()->addDays(7))
            ) {
                array_push($services_to_send, $service);
            };
        };

        return Inertia::render('Dashboard', ['user' => Auth::user(), 'services' => $services_to_send, 'units' => FireBrigadeUnit::all()]);
    }
}
