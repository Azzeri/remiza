<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ScannerController extends Controller
{
    public function index()
    {
        Auth::user()->privilege_id == 1?
            $items = Item::with('sets','databaseItems')->get() :
            $items = Item::where('fire_brigade_unit_id', Auth::user()->fire_brigade_unit_id)->with('sets','databaseItems')->get();
            // dd($items);
        return Inertia::render('scanner',['items' => $items]);
        
        // return Inertia::render('scanner',['items' => Item::with('sets')->get(), 'sets' => Set::where('fire_brigade_unit_id', Auth::user()->id)->get()]);

    }
}