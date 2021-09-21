<?php

namespace App\Http\Controllers;

use App\Models\Usage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UsageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id' => ['required'],
            'description' => 'min:3|max:255|nullable',
            'Udate_start' => ['required', 'date', 'before_or_equal:Udate_end'],
            'Udate_end' => ['required', 'date', 'after_or_equal:Udate_start'],
            'Utime_start' => ['required', 'before:Utime_end', 'date_format:H:i'],
            'Utime_end' => ['required', 'after:Utime_start', 'date_format:H:i'],
        ]);

        $fullDateStart = $request->Udate_start .' ' .$request->Utime_start;
        $fullDateEnd = $request->Udate_end .' ' .$request->Utime_end;

        Usage::create(
            [
                'description' => $request->description,
                'usage_date' =>  $request->Udate_start,
                'usage_time' => $request->Utime_start,
                'usage_minutes' => Carbon::parse($fullDateStart)->diffInMinutes(Carbon::parse($fullDateEnd)),
                'user_id' => Auth::user()->id,
                'item_id' => $request->id
            ]
        );

        return redirect()->back()
            ->with('message', 'Sukces');
    }
}
