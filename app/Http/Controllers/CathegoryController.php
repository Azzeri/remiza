<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Cathegory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
// use Illuminate\Support\Facades\Request;

class CathegoryController extends Controller
{
    public function index()
    {
        $cathegories = Cathegory::with('subcathegories')->get();
        // $cathegories = Cathegory::with('subcathegories')->paginate(10);
        return Inertia::render('cathegories', ['data' => $cathegories]);
    }

    public function store(Request $request)
    {
        $request->parent == -1 ?
            $parent = NULL : $parent = $request->parent;

        $request->validate([
            'name' => ['unique:cathegories', 'required', 'string', 'min:3', 'max:32'],
            // 'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
        ]);
        if ($request->avatar) {
            Cathegory::create(
                [
                    $imageName = time() . '.' . $request->avatar->extension(),
                    $request->avatar->move(public_path('images'), $imageName),
                    'name' => $request->name,
                    'photo_path' => '/images/' . $imageName,
                    'cathegory_id' => $parent,
                ]
            );
        } else {
            Cathegory::create(
                [
                    'name' => $request->name,
                    'cathegory_id' => $parent,
                ]
            );
        }

        return redirect()->back()
            ->with('message', 'Sukces');
    }

    public function update(Request $request, Cathegory $cathegory)
    {
        $request->parent == -1 ?
            $parent = NULL : $parent = $request->parent;

        // echo($request->name);        
        // dd($request->avatar.$request->name);

        $cathegory->update(
            [
                $request->validate([
                    'name' => ['required', 'string', 'min:3', 'max:32', Rule::unique('cathegories')->ignore(Cathegory::find($cathegory->id)),],
                    // 'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
                ]),
                // $imageName = time() . '.' . $request->avatar->extension(),
                // $request->avatar->move(public_path('images'), $imageName),
                'name' => $request->name,
                // 'photo_path' => '/images/' . $imageName,
                'cathegory_id' => $parent
            ]

        );

        return redirect()->back()
            ->with('message', 'Sukces');
    }

    public function destroy(Cathegory $cathegory)
    {
        $cathegory->delete();

        return redirect()->back()
            ->with('message', 'Sukces');
    }
}
