<?php

namespace App\Http\Controllers;

use App\Models\ServiceDatabase;
use Illuminate\Http\Request;

class ServiceDatabaseController extends Controller
{
    public function store(Request $request){
        $this->authorize('create', Cathegory::class);

        $request->validate([
            'name' => ['unique:service_databases', 'required', 'string', 'min:3', 'max:32'],
            'days_to_next' => ['required', 'integer', 'min:1'],
            'cathegory_id' => ['required', 'integer']
        ]);

        ServiceDatabase::create($request->all());

        return redirect()->back()->with('message', 'Sukces');
    }
}
