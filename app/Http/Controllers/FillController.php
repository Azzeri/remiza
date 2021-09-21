<?php

namespace App\Http\Controllers;

use App\Models\Fill;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'item' => ['required'],
            'date_start' => ['required', 'date', 'before_or_equal:date_end'],
            'date_end' => ['required', 'date', 'after_or_equal:date_start'],
            'time_start' => ['required', 'before_or_equal:time_end', 'date_format:H:i:s'],
            'time_end' => ['required', 'after_or_equal:time_start', 'date_format:H:i:s'],
        ]);

        $item = Item::with('cathegory')->where('id', $request->item)->first();
        if (!$item->cathegory->cathegory->fillable) abort(500);

        Fill::create([
            'date_start' => $request->date_start,
            'date_finish' => $request->date_end,
            'time_start' => $request->time_start,
            'time_finish' => $request->time_end,
            'item_id' => $request->item,
            'user_id' => Auth::user()->id
        ]);

        return redirect()->back()->with('message', 'Sukces');
    }
}
