<?php

namespace App\Http\Controllers;

use App\Models\FireBrigadeUnit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FireBrigadeUnitController extends Controller
{
    public function index()
    {
        $units = FireBrigadeUnit::all();

        return Inertia::render('fireBrigadeUnits', ['units' => $units]);
    }
}
