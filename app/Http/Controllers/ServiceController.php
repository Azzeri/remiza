<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Item;
use App\Models\ServiceDatabase;
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

            ]
        );

        return redirect()->back()
            ->with('message', 'Sukces');
    }

    public function activate(Request $request, $id)
    {
        // dd(!$request[0]);
        if (!$request[0]) {
            $item = Item::find($id);
            $item->activated = 1;
            $item->save();

            return redirect()->back()
                ->with('message', 'Sukces');
        };

        $today = Carbon::now();
        $dates = [];
        $index = 0;
        while (true) {
            $date = Carbon::parse($request[$index]['date']);
            $days = ServiceDatabase::find($request[$index]['id'])->days_to_next;

            if ($date->format('Y-m-d') == $today->format('Y-m-d'))
                array_push($dates, $today->addDays($days)->format('Y-m-d'));
            else if ($date->addDays($days)->format('Y-m-d') <= $today->format('Y-m-d'))
                array_push($dates, $today->format('Y-m-d'));
            else if ($date->addDays($days)->format('Y-m-d') > $today->format('Y-m-d')) {
                $date = Carbon::parse($request[$index]['date']);
                array_push($dates, $date->addDays($days)->format('Y-m-d'));
            }

            $index++;
            if ($request[$index] == null)
                break;
        };

        $index = 0;
        while (true) {
            Service::create(
                [
                    'perform_date' => $dates[$index],
                    'item_id' => $id,
                    'service_database_id' => $request[$index]['id']
                ]
            );

            $index++;
            if ($request[$index] == null)
                break;
        }

        $item = Item::find($id);
        $item->activated = 1;
        $item->save();

        return redirect()->back()
            ->with('message', 'Sukces');
    }
}
