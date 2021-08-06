<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function finish(Request $request)
    {
        $service = Service::find($request->id);
        $service->description = $request->desc;
        $service->perform_date = Carbon::now()->format('Y-m-d');
        $service->is_performed = true;
        $service->user_id = Auth::user()->id;
        $service->save();

        Service::create(
            [
                'perform_date' => Carbon::now()->addDays($service->serviceDatabase->days_to_next)->format('Y-m-d'),
                'item_id' => $service->item_id,
                'service_database_id' => $service->service_database_id

            ]);

        return redirect()->back()
            ->with('message', 'Sukces');
    }
}
