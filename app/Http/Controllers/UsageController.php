<?php

namespace App\Http\Controllers;

use App\Models\Usage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UsageController extends Controller
{
    public function insertNew(Request $request)
    {
        $request->validate([
            'description' => 'min:3|max:255|nullable',
            'start' => 'required|before:end',
            'end' => 'required'
        ]);

        Usage::create(
            [
                'description' => $request->description,
                'usage_date' =>  $request->start,
                'usage_minutes' => Carbon::parse($request->end)->diffInMinutes(Carbon::parse($request->start)),
                'user_id' => Auth::user()->id,
                'item_id' => $request->id
            ]
        );

        return redirect()->back()
            ->with('message', 'Sukces');
    }
}
